<?php

namespace Cache;

class Page {

	protected static function pageCacheKey() {
		$cacheKey = 'path:'.\Request::getPath()['path'] . '?'. http_build_query($_GET);
		$cacheKey .= '|lang:'.\Lang\Lang::fetchCurrentLangRef();

		return $cacheKey;
	}

	public static function getData(&$data = null) {
		$cacheKey = self::pageCacheKey();

		if(\Cache::exists($cacheKey)) {
			$data = \Cache::get($cacheKey);

			return true;
		}

		return false;
	}

	public static function storeData($data, $expiresIn = null) {
		$cacheKey = self::pageCacheKey();

		if (!exists($expiresIn)) {
			$expiresIn = 3600 * 24;
		}
		\Cache::set($cacheKey, $data, $expiresIn);
	}
}