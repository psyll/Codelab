<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
	namespace Codelab;
	class format {
		// In ##################################################################
		public static function money(int $number)
		{
		   return number_format((float)$number, 2, '.', ' ');
		}
		public static function size($size)
		{
			if ($size == '' OR $size == 0):
				return '0 B';
			endif;
			if($size >= 1073741824){
				$size = round($size/1024/1024/1024,1) . 'GB';
			}elseif($size >= 1048576){
				$size = round($size/1024/1024,1) . 'MB';
			}elseif($size >= 1024){
				$size = round($size/1024,1) . 'KB';
			}else{
				$size = $size . ' B';
			}
			return $size;
		}
		public static function path(string $path)
		{
			return  str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
		}
		public static function url(string $path)
		{
			return  str_replace(array('\\'), '/', $path);
		}
	}