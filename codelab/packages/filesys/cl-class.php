<?php

namespace cl\filesys;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;

	class file {
		// In ##################################################################
		public static function exists($path)
		{
			if (file_exists($path) AND is_file($path)):
				return true;
			endif;
			return false;
		}
		// In ##################################################################
		public static function size($path)
		{
			if(!file_exists($path)) return false;
			if(is_file($path)) return filesize($path);
			return 0;
		}
		public static function delete($path)
		{
			$fileToRemove = $path;
			if (file_exists($fileToRemove)) {
			// yes the file does exist
			if (@unlink($fileToRemove) === true) {
				return true;
			} else {
					return false;
			}
			} else {
				return false;
			}
		}
	}

	class dir {
		// In ##################################################################
		public static function list($path, $type = null, $ordering = 0)
		{
			$return = scandir($path,$ordering);
				foreach ($return as $key => $value):
					if ($value == '.' OR $value == '..'):
						unset($return[$key]);
					endif;
					if ($type == 'folder' OR $type == 'folders' OR $type == 'dir'):
						if (!is_dir(rtrim($path,"/") . "/" . $value)):
							unset($return[$key]);
						endif;
					endif;
					if ($type == 'file' OR $type == 'files'):
						if (!is_file(trim($path,"/") . "/" . $value)):
							unset($return[$key]);
						endif;
					endif;
				endforeach;
			return $return;
		}
		// In ##################################################################
		function tree($path)
		{
			$rdi = new \RecursiveDirectoryIterator($path);

			$rii = new \RecursiveIteratorIterator($rdi);

			$tree = [];

			foreach ($rii as $splFileInfo) {
				$file_name = $splFileInfo->getFilename();

				// Skip hidden files and directories.
				if ($file_name[0] === '.') {
					continue;
				}

				$path = $splFileInfo->isDir() ? array($file_name => array()) : array($file_name);

				for ($depth = $rii->getDepth() - 1; $depth >= 0; $depth--) {
					$path = array($rii->getSubIterator($depth)->current()->getFilename() => $path);
				}

				$tree = array_merge_recursive($tree, $path);
			}

			return $tree;
		}


		// In ##################################################################
		public static function clear($path)
		{
			$files = glob(rtrim($path, '/') . '/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}
			return true;
		}
		// In ##################################################################
		public static function size($path)
		{
			$bytestotal = 0;
			$path = realpath($path);
			if($path!==false && $path!='' && file_exists($path)){
				foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
					$bytestotal += $object->getSize();
				}
			}
			return $bytestotal;
		}
		// In ##################################################################
		public static function count($path, $type = null)
		{
			$total = 0;
			$path = realpath($path);
			if($path!==false && $path!='' && file_exists($path)){
				foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
					$total++;
				}
			}
			return $total;
		}
		public static function del($path)
		{
			if (!file_exists($path)) return true;
			if (!is_dir($path) || is_link($path)) return unlink($path);
				foreach (scandir($path) as $item) {
					if ($item == '.' || $item == '..') continue;
					if (!self::del($path . "/" . $item)) {
						chmod($path . "/" . $item, 0777);
						if (!self::del($path . "/" . $item)) return false;
					};
				}
				return rmdir($path);
		}
		public static function create($path, $mode = 0755)
		{
			if (!file_exists($path)) {
				mkdir($path, $mode, true);
				return true;
			} else {
				return false;
			}
		}
	}