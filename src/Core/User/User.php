<?php

namespace User;

Class User {

	public static function signUp($email, $password, &$error = null) {
		$email = \DB::escape_string($email);
		$password = \DB::escape_string($password);
		$hashedPass = password_hash($password, PASSWORD_DEFAULT);

		if (self::userExists($email)) {
			$error = \Dictionary::get('email_already_signed');
			return false;
		}

		$sql = "INSERT INTO sys_users SET email = '$email', password = '$hashedPass'";
		if(DB::run($sql)) {
			$userId = \DB::last_insert_id();
			self::storeSession($userId);
			self::sendSignUpMail($email);
			return true;
		} else {
			$error = \Dictionary::get('error_occurred');
			return false;
		}
	}

	public static function socialLog($email, $data, &$error = null) {
		$email = \DB::escape_string($email);

		$users = array();
		if (self::userExists($email, $users)) {
			if (count($users) == 1) {
				//Log In
				$user = reset($users);
				
				if ($user['active']) {
					self::storeSession($user['id']);
					return true;
				} else {
					$error = \Dictionary::get('blocked_user');
					return false;
				}
			}
			$error = \Dictionary::get('error_occurred');
			return false;		
		} else {
			//Sign Up
			$password = \DB::escape_string(Str::random_str(12));
			$hashedPass = password_hash($password, PASSWORD_DEFAULT);

			$sql = "INSERT INTO sys_users SET email = '$email', password = '$hashedPass'";
			if(\DB::run($sql)) {
				$userId = \DB::last_insert_id();
				if (exists($data['name'])) {
					$name = $data['name'];
					$sql = "UPDATE sys_users SET name = '{$name}' WHERE id = $userId";
					\DB::run($sql);
				}
				
				self::storeSession($userId);
				self::sendSignUpMail($email);
				return true;
			} else {
				$error = \Dictionary::get('error_occurred');
				return false;
			}
		}
	}

	public static function logIn($email, $password, &$error = null) {
		$email = \DB::escape_string($email);
		$password = \DB::escape_string($password);

		$users = array();
		if (self::userExists($email, $users)) {
			if (count($users) == 1) {
				$user = reset($users);
				if (password_verify($password, $user['password'])) {
					if ($user['active']) {
						self::storeSession($user['id']);
						return true;
					} else {
						$error = \Dictionary::get('blocked_user');
						return false;
					}					
				} else {
					$error = \Dictionary::get('wrong_password');
					return false;
				}				
			} else {
				$error = \Dictionary::get('error_occurred');
				return false;
			}
		} else {
			$error = \Dictionary::get('email_not_signed');
			return false;
		}
	}

	public static function isLoggedIn() {
		if(session_status() !== PHP_SESSION_ACTIVE)  {
	      session_start();
	    }
		if (exists($_SESSION['user']['id'])) {
			return true;
		} else {
			return false;
		}
	}

	protected static function sendSignUpMail($email) {
		$view = view('emails/signup', array(
	    ), true, 200, false);

	    $search_array = array('#project_name#', '#contacts_page#');
		$replace_array = array(SITE_CONFIGS['info']['name'], SITE_CONFIGS['info']['domain'].SITE_CONFIGS['info']['baseURL'].'/contacts');

		$email = array(
			"email" => $email,
			"subject" => str_replace($search_array, $replace_array, \Dictionary::get('signup_mailing_title')),
			"message" => $view,
		);

	    \Email::send($email);
	}

	protected static function userExists($email, &$list = null) {
		$sql = "SELECT * FROM sys_users AS users WHERE users.dt_delete IS NULL AND users.email = '$email'";
		$users = \DB::results($sql);

		if (!empty($users)) {
			$list = $users;
			return true;
		}

		return false;
	}

	protected static function storeSession($userId) {
		if(session_status() !== PHP_SESSION_ACTIVE)  {
	      session_start();
	    }
		$_SESSION['user']['id'] = $userId;
	}

	public static function logout() {
		if(session_status() !== PHP_SESSION_ACTIVE)  {
	      session_start();
	    }
		unset($_SESSION['user']['id']);
	}

	public static function currentUserInfo() {
		if (self::isLoggedIn()) {
			$user_id = $_SESSION['user']['id'];

			$data = array(
				"account" => self::userAccountInfo($user_id),
				"shipping" => "",
				"billing" => "",				
			);

			return $data;
		}
		return false;
	}

	protected static function userAccountInfo($user_id) {
		$sql = "SELECT * FROM sys_users AS users WHERE users.id = " . (int) $user_id;
		$user = \DB::results($sql, true);

		if (!empty($user)) {
			$output = array(
				"id" => $user_id,
				"name" => $user['name'],
				"email" => $user['email'],
			);
			return $output;
		}

		return false;
	}

}