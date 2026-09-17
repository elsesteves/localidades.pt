<?php

namespace File;

class File {

	protected static $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',        
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'docx'	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

	public static function realFormat($fileName, $finalfileName = false) {
		if(function_exists("mime_content_type")) {
			$fileType = \mime_content_type($fileName);
			$fileFormat = array_search($fileType, self::$mime_types);
		} else {
			$fileFormat = false;
		}		

		if ($fileFormat === false) {
			if ($finalfileName !== false) {
				$nameExploded = explode('.', $finalfileName);
			} else {
				$nameExploded = explode('.', $fileName);
			}			
			$fileFormat = strtolower(end($nameExploded));
		}

		return $fileFormat;
	}

	public static function isAllowedFormat($extension, $alllowedFileFormats) {
		if(in_array($extension, $alllowedFileFormats)) {
			return true;
		} else {
			return false;
		}
	}

	public static function nameCheck($fileName, $folder) {

		$fileExt = explode('.', $fileName);
		$fileExt = strtolower(end($fileExt));

		$fileName_available = false;
		$file_directory =  \SITE_ROOT."/".$folder;
		$fileNameNum = 0;

		while (!$fileName_available) {
		  $fileNameTryArr = explode('.', $fileName);

		  $fileNameTry = '';

		  for ($j=0; $j < count($fileNameTryArr) - 1 ; $j++) {
		    if ($fileNameTry == '') {
		      $fileNameTry = $fileNameTryArr[$j];
		    } else {
		      $fileNameTry .= '.'. $fileNameTryArr[$j];
		    }
		    $fileNameTryFull = $fileNameTry .'.'. $fileExt;
		  }

		  if (file_exists($file_directory.'/'.$fileNameTryFull)) {
		    $fileNameNum++;
		    $fileNameNew = $fileNameTry .'_'.$fileNameNum.'.'.$fileExt;
		    if (!file_exists($file_directory.'/'.$fileNameNew)) {
		    	$fileName_available = true;
		    }
		  } else {
		    $fileName_available = true;
		    $fileNameNew = $fileNameTryFull;
		  }

		}

		return $fileNameNew;
	}

}