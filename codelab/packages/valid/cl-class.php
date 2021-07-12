<?php
namespace Codelab;

class Valid
{
	// In ##################################################################
	public static function email(string $email): bool
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) :
			return true;
		endif;
			return false;
	}
	// In ##################################################################
	public static function md5hash(string $md5)
	{
		if (preg_match('/^[a-f0-9]{32}$/', $md5) == true) :
			return true;
        endif;
			return false;
	}
	// In ##################################################################
	public static function ip(string $ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP)) :
			return true;
        endif;
			return false;
	}
	// In ##################################################################
	public static function url(string $url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL)) :
			return true;
        endif;
		return false;
	}
	// In ##################################################################
	public static function domain(string $url)
	{
		if (filter_var(gethostbyname($url), FILTER_VALIDATE_IP)) :
			return true;
        endif;
		return false;
	}
	// In ##################################################################
	public static function pesel(string $pesel)
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
		if (substr($result, -1, 1) == 0) {
			$check = 0;
        }
		if ($check == $checksum) {
			return true;
		} else {
			return false;
        }
	}
	// * Is the current value even?
	public static function even(int $number): bool
	{
		return ($number % 2 === 0);
	}
	/**
	* Is the current value odd?
	*/
	public static function odd(int $number): bool
	{
		return !self::even($number);
	}
    public static function prime(int $number): bool
    {
        //-n, 0, 1 not allowed
        if ($number < 2) {
            return false;
        }
        //check for single digit primes
        if (in_array($number, array(2, 3, 5, 7))) {
            return true;
        }
        //prime numbers end in 1, 3, 7 or 9 no matter how long they are
        if (!in_array(substr($number, -1), array(1, 3, 7, 9))) {
            return false;
        }
        //if the number is divisible by 3 or 7 (very common) then it's not prime
        if ($number%3 == 0 || $number%7 == 0) {
            return false;
        }
        /*
         * Now find all the numbers up to the square root of potential prime
         * number and test if they divide into it
         */
        //the primes array holds prime numbers to test if they divide into num
        $primes = array(2, 3, 5, 7);
        for ($i = 11, $limit = sqrt($number); $i <= $limit; $i++) {
            //if the number is divisible by a prime number then it's not prime
            $isPrime = true;
            foreach ($primes as $prime) {
                if ($i%$prime == 0) {
                    $isPrime = false;
                    break;
                }
            }
            //check if the increment goes into our number
            if ($isPrime) {
                if ($number%$i == 0) {
                    return false;
                }
                $primes[] = $i;
            }
        }
        //$num is prime - divisible by itself and 1 only
        return true;
    }
}
