<?php

namespace File;

class Doc {

	public static function save($data) {
		$doc = $data["file"];
		$file_directory = $data['folder'];

		$fileName = $doc["name"]; // The file name
		$fileTmpName = $doc["tmp_name"]; // File in the PHP tmp folder
		$fileType = $doc["type"]; // The type of file it is
		$fileSize = $doc["size"]; // File size in bytes
		$fileError = $doc["error"];

		$allowed = ['pdf'];
		//$allowed = ['pdf', 'doc', 'docx'];

		$realFormat = File::realFormat($fileTmpName, $fileName);

		$fileNameNew = File::nameCheck($fileName, $file_directory);

		if (File::isAllowedFormat($realFormat, $allowed)) {
			if ($fileError === 0) {

		    if (!is_dir($file_directory)) {
		      mkdir($file_directory, 0777, true);
		    }
		    $file_destination = $file_directory.'/'.$fileNameNew;
		    $fileDestination = $file_destination;
		    if (move_uploaded_file($fileTmpName, $fileDestination)) {

		    	return array(
		    		"file"		=> $fileDestination,
		    		"name"		=> $fileName,
		    	);

		    }
		  }
		} else {
			return array(
				"error"	=> array(
					"code"	=> 415,
					"title" => "Formato Não Suportado",
					"msg" => "O formato do ficheiro não é suportado.<br>Por favor, carregue apenas ficheiros do tipo indicado na área de carregamento.",
				) 
			);
		}

	}

}