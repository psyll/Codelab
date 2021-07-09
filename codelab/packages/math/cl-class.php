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
class math {
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