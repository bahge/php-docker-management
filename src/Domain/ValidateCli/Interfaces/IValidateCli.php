<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\ValidateCli\Interfaces;

interface IValidateCli
{
    /** @param int $numberArguments
     * @return bool*/
    public function hasArguments(int $numberArguments) : bool;

    /** @param array<int, array<string, mixed>> $configs
     * @return bool*/
    public function isValid(array $configs) : bool;
}
