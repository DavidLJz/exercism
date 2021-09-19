<?php

declare(strict_types=1);

function from(DateTimeImmutable $date): DateTimeImmutable
{
    $t = $date->getTimestamp();

    $d = new DateTimeImmutable;

    return $d->setTimestamp($t + (10 ** 9));
}
