<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Standart\Header;

final class HeaderPart
{
    private static string $HEADER = "version: \"3.8\"

services:
    ";
    /** @return string */
    public function getStandart()
    {
        return self::$HEADER;
    }
}