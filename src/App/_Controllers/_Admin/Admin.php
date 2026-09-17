<?php

namespace Controllers\Admin;

Class Admin {

	public static function loginPage() {
		$data = array();

		view('admin/login', $data, true);
	}

	public static function logIn() {
		$email = \DB::escape_string($_POST['email']);
		$password = \DB::escape_string($_POST['password']);

		\Models\Admin\Access::logIn($email, $password);
	}

	public static function showDashboard() {
		if (!\User\Admin::isLoggedIn()) {
			redirect('/admin/login');
		}

		$file = array(
			"folder" => null,
			"file" => 'dashboard',
		);

		$data = array();

		adminView($file, $data);
	}

}