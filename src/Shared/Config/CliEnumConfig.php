<?php

declare(strict_types=1);

namespace Bahge\Dkman\Shared\Config;

enum CliEnumConfig : string
{
    case DIAGNOSTIC = '-d';
    case GETCOMPONENTSENABLED = '-ls';
}
