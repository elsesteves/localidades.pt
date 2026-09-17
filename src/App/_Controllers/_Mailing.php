<?php

namespace Controllers;

Class Mailing {

	public static function signUpTemplate() {
		view('emails/signup', array(
    	), true);
	}
	
}