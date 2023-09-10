<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Diagnostic\UseCase\Concretes;

use Bahge\Dkman\Domain\Diagnostic\ComponentsEnabled\ComponentsEnabled;
use Bahge\Dkman\Domain\Diagnostic\UseCase\Interfaces\IGetComponentsEnabled;

final class GetComponentsEnabled implements IGetComponentsEnabled
{
    /** @return array<string> | string */
    public function execute(): array | string
    {
        return ComponentsEnabled::$LIST_COMPONENTS;
    }
}