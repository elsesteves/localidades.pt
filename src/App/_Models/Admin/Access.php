<?php

namespace Models\Admin;

Class Access {

	public static function logIn($email, $password) {
		$errors = array();

		if (\User\Admin::logIn($email, $password, $errors)) {
			$url = '/admin';

			if (exists($_POST['ref'])) {
				$url = $_POST['ref'];
			}
		} else {
			$url = '/admin/login';
		}

		redirect($url);
	}
	
}