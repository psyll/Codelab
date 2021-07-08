<?php
// TODO: FILE TO RECODE


namespace cl;
use cl;
	class clUpload {
		public static function process($file, $folder, $options) {
			$target_dir = trim($folder, '/');
			if (@$options['clearFolder'] == true):
				cl\filesys\dir::clear($folder);
			endif;
			cl\filesys\dir::create($folder);
			$error = false;
			$pi = pathinfo($target_dir. '/' . basename($file["name"]));
			$fileName = $pi['filename'];
			$fileName = cl\str::alias($fileName);
			if (isset($options['filename'])):
				$fileName = $options['filename'];
			endif;
			$fileExt = strtolower($pi['extension']);
			$fileFullname = $fileName . '.' . $fileExt;
			$fileTarget = $target_dir . '/' . $fileFullname;
			if (@$options['overwrite'] == true AND file_exists($fileTarget)):
				cl\filesys\file::delete($fileTarget);
			endif;
			// Check if image file is a actual image or fake image
			if ($error == false):
				if (@move_uploaded_file($file["tmp_name"], $fileTarget)):
					return [
						'status' => 'success',
						'message' => 'File uploaded',
						'pathSys' =>$fileTarget,
						'path' => $target_dir. '/' . $fileFullname,
						'file' => $fileFullname,
						'filename' => $fileName,
						'extension' => $fileExt
					];
				else:
					return [
						'status' => 'error',
						'message' => 'File upload error ' . $fileTarget
					];
				endif;
			 else:
				return [
					'status' => 'error',
					'message' => 'An unknown error occured' . $fileTarget
				];
			endif;
		}
	}
