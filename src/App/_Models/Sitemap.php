<?php

namespace Models;

Class Sitemap {

	protected static $langs = array();

	protected static function lastModTime($date) {
		$dt = date("Y-m-d", strtotime($date));
		return $dt;
	}

	public static function getLinks() {
		$links = array();
		self::$langs = \Lang\Lang::getList();

		$links = arrayMergeAll(array(
			self::addHome(),
			self::addContacts(),
			self::addProjects(),
			self::addSolutions(),
			self::addPages(),
			self::addBlog(),
		));

		return $links;

		view('sitemap/sitemap', array(
			"links" => $links,
		), true);
	}

	public static function addHome() {
		$links = array();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			array_push($links, array(
				"url" => "/{$lang_ref}",
				"priority" => 1,
			));
		}

		return $links;
	}

	public static function addContacts() {
		$links = array();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			array_push($links, array(
				"url" => "/{$lang_ref}/contacts",
				"priority" => 1,
			));
		}

		return $links;
	}

	protected static function addProjects() {
		$links = array();
		$projectsModel = new \Models\Projects();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			array_push($links, array(
				"url" => "/{$lang_ref}/projects",
				"priority" => 0.9,
			));

			$projects = $projectsModel->items(null, array(
				"lang_id" => $lang_id,
			));
			
			foreach ($projects as $project) {
				$title = $project['title'] ? $project['title'] : $project['name'];
				$title = \Data\Str::permalink_clean($title);
				array_push($links, array(
					"url" => "/{$lang_ref}/projects/{$project['id']}/{$title}",
					"lastmod" => self::lastModTime($project['time_lastmod']),
					"priority" => 0.8,
				));
			}
		}

		return $links;
	}

	public static function addSolutions() {
		$links = array();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			array_push($links, array(
				"url" => "/{$lang_ref}/solutions",
				"priority" => 0.9,
			));
		}

		return $links;
	}

	public static function addPages() {
		$links = array();
		$pagesModel = new \Models\Pages();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			$pages = $pagesModel->items(null, array(
				"lang_id" => $lang_id,
				"exclude_parents" => array(1),
			));
			
			foreach ($pages as $page) {
				$title = $page['title'] ? $page['title'] : $page['name'];
				$title = \Data\Str::permalink_clean($title);
				array_push($links, array(
					"url" => "/{$lang_ref}/pages/{$page['id']}/{$title}",
					"lastmod" => self::lastModTime($page['time_lastmod']),
					"priority" => 0.4,
				));
			}
		}

		return $links;
	}

	public static function addBlog() {
		$links = array();
		$blogModel = new \Models\Blog();

		foreach (self::$langs as $lang) {
			$lang_id = $lang['id'];
			$lang_ref = $lang['reference'];

			$pages = $blogModel->items(null, array(
				"lang_id" => $lang_id,
			));
			
			foreach ($pages as $page) {
				$title = $page['title'];
				$title = \Data\Str::permalink_clean($title);
				array_push($links, array(
					"url" => "/{$lang_ref}/blog/{$page['id']}/{$title}",
					"lastmod" => self::lastModTime($page['time_lastmod']),
					"priority" => 0.7,
				));
			}
		}

		return $links;
	}

}