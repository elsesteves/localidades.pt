<?php

namespace File;

class Image {

	protected static $images = array(
		"global" => array(
			//16:9			
			"resize" => array(
				"width"		=> 800,
				"height"	=> 450
			),
			"thumb" => array(
				"width"		=> 400,
				"height"	=> 225
			),
		),
	);

	protected static function fetchImageSizes($module) {		
		$sql = "SELECT md_ir.name, md_ir.width_px, md_ir.height_px
					FROM sys_md_images_resizes AS md_ir
					INNER JOIN sys_modules AS md
						ON md_ir.id_module = md.id
					WHERE md_ir.active = 1
						AND md_ir.dt_delete IS NULL
						AND md.name = '$module'
						AND md.dt_delete IS NULL";
		$resizes = \DB::results($sql);

		if (!exists($resizes)) {
			return false;
		}

		$output = array();
		foreach($resizes as $resize) {
			$output[$resize['name']] = array(
				"width"	=> (int) $resize['width_px'],
				"height" => (int) $resize['height_px'],
			);
		}

		self::$images[$module] = $output;
		return $output;
	}

	protected static function getImageSizes($module) {
		if (isset(self::$images[$module])) {
			$imgSizes = self::$images[$module];
		} else {
			$imgSizes = self::fetchImageSizes($module);
			/*if ($imgSizes === false) {
				$imgSizes = self::$images['global'];
			}*/	
		}

		return $imgSizes;
	}

	protected static function findFolder($data) {
		$folder = 'media/'.$data['module'];

		if(exists($data['submodule'])) {
			$folder = '/'.$data['submodule'];	
		}

		$folder .= '/'.$data['parent'].'/img';

		if(exists($data['resize'])) {
			$folder .= '/'.$data['resize'];
		}

		return $folder;
	}

	public static function save($data) {
		$image = $data["file"];
		//$file_directory = $data['folder'];

		$file_directory = self::findFolder($data);

		$fileName = $image["name"]; // The file name
		$fileTmpName = $image["tmp_name"]; // File in the PHP tmp folder
		$fileType = $image["type"]; // The type of file it is
		$fileSize = $image["size"]; // File size in bytes
		$fileError = $image["error"]; // 0 for false... and 1 for true

		$allowed = ['jpg', 'jpe', 'jpeg', 'jpg', 'png', 'bmp'];

		$realFormat = File::realFormat($fileTmpName, $fileName);

		$fileNameNew = File::nameCheck($fileName, $file_directory);

		if (File::isAllowedFormat($realFormat, $allowed)) {
		  if ($fileError === 0) {

		  	$file_directory_orig = $file_directory;
		  	$file_directory =  \SITE_ROOT."/".$file_directory;

		    if (!is_dir($file_directory)) {
		      mkdir($file_directory, 0777, true);
		    }
		    $file_destination = $file_directory.'/'.$fileNameNew;
		    $fileDestination = $file_destination;
		    if (move_uploaded_file($fileTmpName, $fileDestination)) {

		    	$resizes = self::createImageResizes($fileDestination, $data);

		    	return array(
		    		"original" => $file_directory_orig .'/'.$fileNameNew,
		    		"resizes" => $resizes
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

	public static function createImageThumbs($img_src, $module) {
		return array(
			"resize"	=> self::resizeImage($img_src, $module, 'resize'),
			"thumb"		=> self::resizeImage($img_src, $module, 'thumb'),
		);
	}

	protected static function createImageResizes($img_src, $data) {
		$imgSizes = self::getImageSizes($data['base_table']);
		$resizes = array();

		if(empty($imgSizes)) {
			return false;
		}

		foreach ($imgSizes as $resizeName => $resizeData) {
			$newData = $data;
			$newData['resize'] = $resizeName;
			$resizes[$resizeName] = self::resizeImage($img_src, $newData);
		}

		return $resizes;
	}


	public static function resizeImage($img_src, $data) {	
		$img_src = str_replace('/', '\\', $img_src);

		$fileName = explode('\\', $img_src);
		$fileName = end($fileName);

		$baseTable = $data['base_table'];
		$resizeType = $data['resize'];

		$file_directory = self::findFolder($data);
		$fileNameNew = File::nameCheck($fileName, $file_directory);

		$file_directory_orig = $file_directory;
	  	$file_directory =  \SITE_ROOT."/".$file_directory;

		if (!is_dir($file_directory)) {
	      mkdir($file_directory, 0777, true);
	    }
	    $fileDestination = $file_directory."/".$fileNameNew;

		$img_orig = self::createFromFile($img_src);
		$srcSize = getimagesize($img_src);


		$imgSizes = self::getImageSizes($baseTable);

		if (!isset($imgSizes[$resizeType])) {
			return false;
		}
		$imgSizes = $imgSizes[$resizeType];
		$dest_w = $imgSizes['width'];
		$dest_h = $imgSizes['height'];

		/*
		$imageResize = new \Gumlet\ImageResize($img_src);
		$imageResize->resize($dest_w, $dest_h);
		$imageResize->save($fileDestination);
		*/
		
		$img_final = imagecreatetruecolor($dest_w, $dest_h);
		$img_white = imagecolorallocate($img_final, 255, 255, 255);
		imagefill($img_final, 0, 0, $img_white);
		imagecopyresampled($img_final, $img_orig, 0, 0, 0, 0, $dest_w, $dest_h, $srcSize[0], $srcSize[1]);
		imagejpeg($img_final, $fileDestination);

		return $file_directory_orig .'/'.$fileNameNew;
	}

	public static function createFromFile($filename) {

		if (!file_exists($filename)) {
			throw new \Exception('File "'.$filename.'" not found.');
		}

		$realFormat = File::realFormat($filename);

  		switch ($realFormat) {
  			case 'jpe':
		    case 'jpeg':
		    case 'jpg':
		    return imagecreatefromjpeg($filename);
		    break;

	    case 'png':
		    return imagecreatefrompng($filename);
		    break;

	    case 'gif':
	      return imagecreatefromgif($filename);
	      break;

     	case 'bmp':
	      return imagecreatefrombmp($filename);
	      break;

      	default:
	      throw new Exception('File "'.$filename.'" is not valid jpg, png or gif image.');
	      break;
    	}
	}

}