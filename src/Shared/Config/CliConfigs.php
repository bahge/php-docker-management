<?php

declare(strict_types=1);

namespace Bahge\Dkman\Shared\Config;

final class CliConfigs
{
    /** @var array<string, int|string|string[]> */
    public static array $DIAGNOSTIC = [
        'args' => 2, 
        'man' => '-d <caminho do arquivo><arquivo.yaml>', 
        'run' => '\Cli\Concretes\DiagnosticRunnable', 
        'useCase' => '\Domain\Diagnostic\UseCase\Concretes\Diagnostic',
        'properties' => ['path']
    ];

    /** @var array<string, int|string|string[]> */
    public static array $GETCOMPONENTSENABLED = [
        'args' => 1, 
        'man' => '-ls',
        'run' => '\Cli\Concretes\ComponentsEnabledRunnable', 
        'useCase' => '\Domain\Diagnostic\UseCase\Concretes\GetComponentsEnabled',
        'properties' => []
    ];

}