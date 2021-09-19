<?php

declare(strict_types=1);

function toRna(string $dna): string
{
    $conversion = [
        'G' => 'C',
        'C' => 'G',
        'T' => 'A',
        'A' => 'U',
    ];

    $dna_array = str_split(strtoupper($dna));

    $rna = '';

    foreach ($dna_array as $char) {
        $rna .= $conversion[ $char ] ?? '';
    }

    return $rna;
}
