<?php

declare(strict_types=1);

function isValid(string $number): bool
{
    $number = trim($number);

    if ( strlen($number) < 2 || preg_match('/[^\d\s]/', $number) ) {
       return false;
    }

    $digits = str_split(str_replace(' ', '', $number));
    $digits = array_reverse($digits);

    $second = false;

    foreach ($digits as $i => $digit) {
        $digit = (int) $digit;

        if ( $second ) {
            $digit *= 2;

            if ( $digit > 9 ) {
                $digit -= 9;
            }
        } 

        $digits[$i] = $digit;
        $second = !$second;
    }

    return array_sum($digits) % 10 === 0;
}
