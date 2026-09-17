<?php

namespace Controllers;

Class User {

	public static function accountDataForm() {
		if (!\User::isLoggedIn()) {
			redirect('/login?ref=/customer/account');
		} else {
			view('customer/account', array(
				"info" => User::currentUserInfo(),
	    	));
		}
	}

	public static function loginPage() {
		$errors = \Form::getFormErrors();
		view('login', array(
			"errors" => $errors,
    	));
	}

	public static function recoveryPage() {

	}

	public static function loginForm() {
		$validation = new \Form();
	    $isValid = $validation->validate('login', array(
	      "token" => array(
	        "alias" => "",
	        "rules" => ["csrf_token"],
	      ),
	      "log_email"  => array(
	        "alias" => \Dictionary::get('email_address'),
	        "rules" => ['string', 'email', 'min:6', 'required'],
	      ),
	      "log_password"  => array(
	        "alias" => \Dictionary::get('password'),
	        "rules" => ['string', 'min:6', 'required'],
	      ),
	      "info"  => array(
	        "alias" => "",
	        "rules" => ['honeyPotValue'],
	      ),
	      "microtime"  => array(
	        "alias" => "",
	        "rules" => ['honeyPotMicrotime', 'required'],
	      ),
	      
	    ));

	    if ($isValid) {
	    	$error = '';
		    if(\User::logIn($_POST['log_email'], $_POST['log_password'], $error)) {
		    	if (exists($_POST['ref'])) {
		    		redirect($_POST['ref']);
		    	}
		      	redirect('/cart');
		    }
		    \Form::addMainError('login', $error);
	    }

	    $link = '/login';
	    if (exists($_POST['ref'])) {
	    	$link = '/login?ref='.$_POST['ref'];
	    }
	    redirect($link);
	}

	public static function signupForm() {
		$validation = new \Form();
	    $isValid = $validation->validate('signup', array(
	      "token" => array(
	        "alias" => "",
	        "rules" => ["csrf_token"],
	      ),
	      "sign_email"  => array(
	        "alias" => \Dictionary::get('email_address'),
	        "rules" => ['string', 'email', 'min:6', 'required'],
	      ),
	      "sign_password"  => array(
	        "alias" => \Dictionary::get('password'),
	        "rules" => ['string', 'min:6', 'required', 'confirmed'],
	      ),
	      "info"  => array(
	        "alias" => "",
	        "rules" => ['honeyPotValue'],
	      ),
	      "microtime"  => array(
	        "alias" => "",
	        "rules" => ['honeyPotMicrotime', 'required'],
	      ),
	      
	    ));

	    if ($isValid) {
	    	$error = '';
		    if(\User::signUp($_POST['sign_email'], $_POST['sign_password'], $error)) {
		    	if (exists($_POST['ref'])) {
		    		redirect($_POST['ref']);
		    	}
		      	redirect('/cart');
		    }
		    \Form::addMainError('signup', $error);
	    }

	    $link = '/login';
	    if (exists($_POST['ref'])) {
	    	$link = '/login?ref='.$_POST['ref'];
	    }
	    redirect($link);
	}

	public static function facebookLogin() {
		$error = '';

		$provider = UserFacebook::getProvider();

		//$_SESSION['oauth2state'] = $provider->getState();

		$error_code = filter_input(INPUT_GET, "error_code", FILTER_SANITIZE_STRIPPED);
		$error_msg = filter_input(INPUT_GET, "error_message", FILTER_SANITIZE_STRIPPED);
		if (!empty($_GET['error_message'])) {
			$error = $error_msg;
			Validation::addMainError('login', $error);
			return false;
		}
		
		$code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRIPPED);
		if ($code) {
			$token = $provider->getAccessToken('authorization_code', [
			    'code' => $code
			]);

			$user = $provider->getResourceOwner($token);

			$email = $user->getEmail();
			$data = array(
				"name" => $user->getName()
			);

			if(User::socialLog($email, $data, $error)) {
		      	redirect('/cart');
		    }
		}
	}

	public static function googleLogin() {
		$error = '';

		$provider = UserGoogle::getProvider();

		//$_SESSION['oauth2state'] = $provider->getState();

		$error_msg = filter_input(INPUT_GET, "error", FILTER_SANITIZE_STRIPPED);
		if (!empty($_GET['error'])) {
			$error = $error_msg;
			Validation::addMainError('login', $error);
			return false;
		}
		
		$code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRIPPED);
		if ($code) {
			$token = $provider->getAccessToken('authorization_code', [
			    'code' => $code
			]);

			$user = $provider->getResourceOwner($token);

			$email = $user->getEmail();
			$data = array(
				"name" => $user->getName()
			);

			if(User::socialLog($email, $data, $error)) {
		      	redirect('/cart');
		    }
		}
	}

}