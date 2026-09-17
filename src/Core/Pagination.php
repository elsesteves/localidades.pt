<?php

class Pagination {

	public static function lastPage(int $totalItemCount, int $pageItemLimit) {
		$lastPageNum = ceil($totalItemCount / $pageItemLimit);

		return $lastPageNum;
	}

	public static function getOffset(int $pageItemLimit, int $page = 1) {
		if ($page < 1) {
			$page = 1;
		}

		$offset = ($page - 1) * $pageItemLimit;

		return $offset;
	}
}