<?php
	/*
		CODELAB
		Homepage: https://psyll.com/products/codelab
		© Jaroslaw Szulc <jarek@psyll.com>
		© Psyll.com <info@psyll.com>
		This file is part of the Codelab package.
		Distributed under the PPCL license (http://psyll.com/license/ppcl)
	*/
namespace cl;
	class valid {
		// In ##################################################################
		public static function email($string)
		{
			if (filter_var($string, FILTER_VALIDATE_EMAIL))
			{
				return true;
			} else
			{
				return false;
			}
		}

		// In ##################################################################
		public static function md5hash($md5)
		{
			if (preg_match('/^[a-f0-9]{32}$/', $md5) == true)
			{
				return true;
			} else
			{
				return false;
			}
		}

		// In ##################################################################
		public static function ip($ip)
		{
			if (filter_var($ip, FILTER_VALIDATE_IP))
			{
				return true;
			} else
			{
				return false;
			}
		}

		// In ##################################################################
		public static function url($url)
		{
			$validation = filter_var($url, FILTER_VALIDATE_URL);

			if ( $validation ) $output = true;
			else $output = false;

			return $output;
		}

		// In ##################################################################
		public static function domain($url)
		{
			if(filter_var(gethostbyname($url), FILTER_VALIDATE_IP))
			{
				return true;
			} else {
				return false;
			}
		}


		// In ##################################################################
		public static function pesel($pesel)
		{
			$a = substr($pesel, 0, 1);
			$b = substr($pesel, 1, 1);
			$c = substr($pesel, 2, 1);
			$d = substr($pesel, 3, 1);
			$e = substr($pesel, 4, 1);
			$f = substr($pesel, 5, 1);
			$g = substr($pesel, 6, 1);
			$h = substr($pesel, 7, 1);
			$i = substr($pesel, 8, 1);
			$j = substr($pesel, 9, 1);
			$checksum = substr($pesel, 10, 1);

			$result = $a + 3*$b + 7*$c + 9*$d + $e + 3*$f + 7*$g + 9*$h + $i + 3*$j;

			$check = 10 - substr($result, -1, 1);

			if (substr($result, -1, 1) == 0)
				$check = 0;

			if ($check == $checksum)
				return true;
			else
				return false;
		}



// * Is the current value even?
public static function even(int $number): bool
{
	return ($number % 2 === 0);
}

/**
* Is the current value negative; less than zero.
*/
public static function negative(float $number): bool
{
return ($number < 0);
}


/**
* Is the current value odd?
*/
public static function odd(int $number): bool
{
return !self::even($number);
}





	}