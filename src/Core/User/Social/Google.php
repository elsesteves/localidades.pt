<?php

/* https://github.com/thephpleague/oauth2-google */

namespace User\Social;

Class Google extends \User\User {

	protected static $configs;

	public static function start() {
		global $socialLogins;
		self::$configs = SITE_CONFIGS['oauth']['social']['google'];
	}

	public static function getProvider() {
		if (!exists(self::$configs)) {
			self::start();
		}

		$provider = new \League\OAuth2\Client\Provider\Google([
		    'clientId'     => self::$configs['app_id'],
		    'clientSecret' => self::$configs['app_secret'],
		    'redirectUri'  => self::$configs['app_redirect'],
		    'hostedDomain' => self::$configs['hosted_domain'],
		]);

		return $provider;
	}

	public static function getAuthorizationUrl() {
		$provider = self::getProvider();

		//URL to send to user for login
		$authURL = $provider->getAuthorizationUrl();

		return $authURL;
	}

}