<?php

/* https://github.com/thephpleague/oauth2-facebook */

namespace User\Social;

Class Facebook extends \User\User {

	protected static $configs;

	public static function start() {
		global $socialLogins;
		self::$configs = SITE_CONFIGS['oauth']['social']['facebook'];
	}


	public static function getProvider() {
		if (!exists(self::$configs)) {
			self::start();
		}

		$provider = new \League\OAuth2\Client\Provider\Facebook([
			'clientId'          => self::$configs['app_id'],
		    'clientSecret'      => self::$configs['app_secret'],
		    'redirectUri'       => self::$configs['app_redirect'],
		    'graphApiVersion'   => self::$configs['app_version'],
		]);

		return $provider;
	}

	public static function getAuthorizationUrl() {
		$provider = self::getProvider();

		//URL to send to user for login
		$authURL = $provider->getAuthorizationUrl(array(
			"scope"	=> array("email")
		));

		return $authURL;
	}

}