<?php
namespace Codelab;

class Datetime
{
	public static function now()
	{
			return  date('Y-m-d H:i:s');
	}
	public static function date()
    {
				return  date('Y-m-d');
	}
	public static function time()
    {
		return  date('H:i:s');
	}
}
