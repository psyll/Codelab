<?php
namespace Codelab;

use Parsedown;

class Markdown
{
	public static function parse(string $content)
	{
		$Parsedown = new Parsedown();
		return $Parsedown->text($content); # prints: <p>Hello <em>Parsedown</em>!</p>
	}
}
