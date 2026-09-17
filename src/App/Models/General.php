<?php

namespace Models;

Class General {

	protected static $distritoModel;
	protected static $concelhoModel;
	protected static $freguesiaModel;

	protected static $distritoList;
	protected static $concelhoList;
	protected static $freguesiaList;

	protected static function getLocalidadesModels() {
		self::$distritoModel = new \Models\Distrito();
		self::$concelhoModel = new \Models\Concelho();
		self::$freguesiaModel = new \Models\Freguesia();
	}

	protected static function checkLocalidadesModels() {
		if (!exists(self::$distritoModel) || !exists(self::$concelhoModel) || !exists(self::$freguesiaModel)) {
			self::getLocalidadesModels();
		}
	}

	public static function getLocalidades($row, &$item) {
		self::checkLocalidadesModels();

		if ($row['id_freguesia']) {
			if(exists(self::$freguesiaList[$row['id_freguesia']])) {
				$item['freguesia'] = self::$freguesiaList[$row['id_freguesia']];
			} else {
				$freguesia = self::$freguesiaModel->itemsBasicInfo(array("id" => $row['id_freguesia']));
				if (exists($freguesia[$row['id_freguesia']])) {
					$item['freguesia'] = $freguesia[$row['id_freguesia']];
					self::$freguesiaList[$row['id_freguesia']] = $freguesia[$row['id_freguesia']];
				}
			}
		}

		if ($row['id_concelho']) {
			if(exists(self::$concelhoList[$row['id_concelho']])) {
				$item['concelho'] = self::$concelhoList[$row['id_concelho']];
			} else {
				$concelho = self::$concelhoModel->itemsBasicInfo(array("id" => $row['id_concelho']));
				if (exists($concelho[$row['id_concelho']])) {
					$item['concelho'] = $concelho[$row['id_concelho']];
					self::$concelhoList[$row['id_concelho']] = $concelho[$row['id_concelho']];
				}
			}
		}

		if ($row['id_distrito']) {
			if(exists(self::$distritoList[$row['id_distrito']])) {
				$item['distrito'] = self::$distritoList[$row['id_distrito']];
			} else {
				$distrito = self::$distritoModel->itemsBasicInfo(array("id" => $row['id_distrito']));
				if (exists($distrito[$row['id_distrito']])) {
					$item['distrito'] = $distrito[$row['id_distrito']];
					self::$distritoList[$row['id_distrito']] = $distrito[$row['id_distrito']];
				}
			}
		}
	}
}