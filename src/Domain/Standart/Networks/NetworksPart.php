<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Standart\Networks;

final class NetworksPart
{
    /** @param string $network
     * @return string */
    public function getStandart(string $network) : string
    {
        return sprintf("networks:
    %s:
        driver: bridge",
        $network);
    }
}