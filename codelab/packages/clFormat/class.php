<?php
	class clFormat {
		// In ##################################################################
		public static function money($number)
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
		public static function path($path)
		{
			return  str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
		}
		public static function url($path)
		{
			return  str_replace(array('\\'), '/', $path);
		}
	}