<?php

declare(strict_types=1);

namespace Bahge\Dkman\Cli\Interfaces;

abstract class AbstractRunnable
{
    public abstract function run():void;
}
