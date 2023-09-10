<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Diagnostic\UseCase\Interfaces;

interface IGetComponentsEnabled
{
    /** @return array<string> | string */
    public function execute(): array | string;
}