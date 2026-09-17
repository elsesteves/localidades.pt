<?php

namespace User;

Class Admin {

	public static function addToLog(array $data) {
		/*$data = array(
			string "module",
			string "action",
			int "id",
			bool "allowed" :optional,
			bool "visible" :optional,
			int "user_id" :optional
		);*/

		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$ip = self::getIPAddress();

		$adminData = $_SESSION['admin'];

		$lang_id = 1;

		$allowed = $data['allowed'] ? 1 : 0;
		$visible = $data['visible'] ? 1 : 0;

		$userID = 0;
		if (isset($data['user_id'])) {
			$userID = (int) $data['user_id'];
		} elseif(self::isLoggedIn()) {
			$user = self::getAdminInfo();
			$userID = (int) $user['profile']['id'];
		} else {
			$userID = 0;
		}

		$sql = "SELECT * FROM sys_actions WHERE name = '{$data['action']}'";
		$actionData = \DB::results($sql, true);
		$actionID = $actionData['id'];

		$sql = "SELECT * FROM sys_modules WHERE name = '{$data['module']}'";
		$moduleData = \DB::results($sql, true);
		$moduleID = $moduleData['id'];

		/*
		$sql = "INSERT INTO admin_logs(fk_user, fk_action, module_id, target_id, allowed, user_agent, ip_address, visible, target_lang) 
					VALUES($userID, '$actionID', $moduleID, {$data['id']}, $allowed, '$user_agent', '$ip', $visible, $lang_id)";
		\DB::run($sql);
		*/
	}

	public static function isActionAllowed($group, $permission, $action, $id) {
  		$action = str_replace($group.'_', '', $action);

		$isDev = false;
		$isAllowed = self::permissionCheck($group, $permission, $isDev);

		self::addToLog(array(
			"module" => $group,
			"action" => $action,
			"id" => $id,
			"allowed" => $isAllowed,
			"visible" => !$isDev,
		));

		return $isAllowed;
	}

	public static function permissionCheck($group, $permission, &$isDev = false) {
		$isDev = false;
		$permission = str_replace($group.'_', '', $permission);
	  
		if (exists($_SESSION['admin']['permissions']['dev']['root'])) {
			//Is root
			$isDev = true;
			return true;
		}

		if (exists($_SESSION['admin']['permissions'][$group][$permission])) {
			//Has permission
			return true;
		} else {
			//Doesn't have permission
			return false;
		}
	}

	protected static function getIPAddress() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	public static function isLoggedIn() {
		if(session_status() !== PHP_SESSION_ACTIVE)  {
	      session_start();
	    }
		
		if (exists($_SESSION['admin']['profile'])) {
			return true;
		}

		return false;
	}

	public static function getAdminInfo() {
		return $_SESSION['admin'];
	}

	protected static function storeAdminInfo($data) {
		$admin = array(
			"profile" => array(
				"id"  => $data['id'],
				"name"  => $data['name'],
				"email"  => $data['email'],
			),
	      	"permissions" => self::getAdminPermissions($data['id']),
	    );

	    $_SESSION['admin'] = $admin;
	    return $admin;
	}

	protected static function getAdminPermissions(int $userID) {
		$sql = "SELECT smp.id, sp.name, smp2u.active, smp.id_module, sm.name AS 'module_name'
				FROM sys_md_permissions AS smp
					LEFT JOIN sys_md_permissions2users AS smp2u
						ON smp2u.id_md_permission = smp.id
							AND smp2u.id_user = $userID
					INNER JOIN sys_permissions AS sp
						ON smp.id_permission = sp.id
					LEFT JOIN sys_modules AS sm
						ON smp.id_module = sm.id
				ORDER BY -sm.pos DESC, -sp.pos DESC";
						
		$results = \DB::results($sql);

		$permissions = array();
		foreach ($results as $row) {
			$permissions[$row['module_name']][$row['name']] = $row['active'];
		}

		return $permissions;
	}

	protected static function storeLoginErrors($errors = array()) {
		$_SESSION['admin']['errors']['login'] = $errors;
	}

	public static function logIn(string $email, string $password, &$errors = array()) {
		$sql = "SELECT * 
					FROM sys_users 
					WHERE is_admin = 1
						AND email  = '$email'";
		$data = \DB::results($sql, true);

		if (empty($data)) {
			//Não há nenhuma conta com esse email
			self::addToLog(array(
				"module" => 'admin',
				"action" => 'login',
				"id" => 0,
				"allowed" => false,
				"visible" => true,
			));

			array_push($errors, 'Esta conta não está registada!<br>Confirme se indicou o endereço certo ou se necessita de solicitar ao admnistrador que crie uma nova conta.');
		} else {
			if (!$data['active'] || $data['deleted']) {
				//Utilizador Bloqueado ou Eliminado
				self::addToLog(array(
					"module" => 'admin',
					"action" => 'login',
					"id" => $data['id'],
					"allowed" => false,
					"visible" => true,
				));

				array_push($errors, 'A sua conta não está autorizada a aceder!<br>Solicite ao admnistrador que desbloqueie a sua conta.');
			} else {

				if (password_verify($password, $data['password'])) {
			    	//Password está correta
				    $admin = self::storeAdminInfo($data);

					if (isset($admin['permissions']['dev']['root'])) {
						$visible = false;
					} else {
						$visible = true;
					}

				    self::addToLog(array(
						"module" => 'admin',
						"action" => 'login',
						"id" => $data['id'],
						"allowed" => true,
						"visible" => $visible,
					));
			    
					return true;

			  } else {
			    //Password está incorreta
			    admin_log('admin', 'login', $result['id'], false, true);

			    self::addToLog(array(
					"module" => 'admin',
					"action" => 'login',
					"id" => $data['id'],
					"allowed" => false,
					"visible" => true,
				));

			    array_push($errors, 'A palavra-passe inserida está incorreta!<br>Caso não consiga aceder, solicite ao admnistrador que lhe forneça uma nova.');
			  }

			}
		}

		if (!empty($errors)) {
			self::storeLoginErrors($errors);
			return false;
		}
	}
}