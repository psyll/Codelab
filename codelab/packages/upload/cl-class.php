<?php
namespace Codelab;

use Codelab;

class Upload
{
	public static function file(string $source, string $destination, array $options)
	{
		$target_dir = trim($destination, '/');
		if (@$options['clearFolder'] == true) :
			Codelab\Filesys\dir::clear($destination);
        endif;
		Codelab\Filesys\dir::create($destination);
		$error = false;
		$pi = pathinfo($target_dir. '/' . basename($source["name"]));
		$fileName = $pi['filename'];
		$fileName = Codelab\Str::alias($fileName);
		if (isset($options['filename'])) :
			$fileName = $options['filename'];
        endif;
		$fileExt = strtolower($pi['extension']);
		$fileFullname = $fileName . '.' . $fileExt;
		$fileTarget = $target_dir . '/' . $fileFullname;
		if (@$options['overwrite'] == true and file_exists($fileTarget)) :
			Codelab\Filesys\file::delete($fileTarget);
        endif;
		// Check if image file is a actual image or fake image
		if ($error == false) :
			if (@move_uploaded_file($source["tmp_name"], $fileTarget)) :
				return [
					'status' => 'success',
					'message' => 'File uploaded',
					'pathSys' =>$fileTarget,
					'path' => $target_dir. '/' . $fileFullname,
					'file' => $fileFullname,
					'filename' => $fileName,
					'extension' => $fileExt
				];
            else :
					return [
						'status' => 'error',
						'message' => 'File upload error ' . $fileTarget
					];
            endif;
        else :
				return [
					'status' => 'error',
					'message' => 'An unknown error occured' . $fileTarget
				];
        endif;
	}
}
