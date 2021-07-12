<?php
namespace Codelab;

class Math
{
    // * Get relative percent
	public static function relativePercent(float $normal, float $current): string
	{
        if (!$normal || $normal === $current) {
            return '100';
		}
        $normal = abs($normal);
        $percent = round($current / $normal * 100);
        return number_format($percent, 0, '.', ' ');
	}
}
