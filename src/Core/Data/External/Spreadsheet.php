<?php

namespace Data\External;

use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use \PhpOffice\PhpSpreadsheet\Spreadsheet

class Spreadsheet {

	public static function getData($inputFileName) {
		$spreadsheet = IOFactory::load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		$header = array();
		foreach ($sheetData[1] as $headerCell) {
			array_push($header, $headerCell);
		}

		$body = array();
		$highestRow = array_key_last($sheetData);
		for ($i=2; $i <= $highestRow ; $i++) { 
			$row = array();
			$highestColIndex = array_key_last($sheetData[$i]);
			$highestColIndex = Coordinate::columnIndexFromString($highestColIndex);

			for ($j=0; $j < $highestColIndex; $j++) { 
				$excelCol = \Data\Str::num2alpha($j);
				$colName = $header[$j];
				$row[$colName] = $sheetData[$i][$excelCol];
			}

			array_push($body, $row);
		}

		$data = array(
			"header" => $header,
			"body" => $body,
		);

		return $data;
	}

	public static function outputData($filename, $body) {
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		foreach($body as $cellName => $cellValue) {
			$sheet->setCellValue($cellName, $cellValue);
		}

		//$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
		header('Content-Disposition: attachment;filename="'.$filename . '_' . time() .'.xlsx"');
		header('Cache-Control: max-age=0');

		$xlsxWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		exit($xlsxWriter->save('php://output'));
	}

}