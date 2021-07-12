<?php
namespace Codelab;
	class redirect {
		// In ##################################################################
		public static function url(string $url)
		{
			header('Location: ' . $url); // temp
		   if (headers_sent()){
				die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
			}else{
				header('Location: ' . $url);
				die();
			}
		}
		public static function self()
		{
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
			$url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		   if (headers_sent()){
				die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
			}else{
				header('Location: ' . $url);
				die();
			}
		}
		public static function domain()
		{

			$url = CL_PROTOCOL . '://' . CL_DOMAIN;

		   if (headers_sent()){
				die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
			}else{
				header('Location: ' . $url);
				die();
			}
		}


	}