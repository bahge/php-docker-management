<?php

declare(strict_types=1);

namespace Bahge\Dkman\Cli\Concretes;

use Bahge\Dkman\Cli\Interfaces\AbstractRunnable;
use Bahge\Dkman\Domain\Diagnostic\UseCase\Concretes\GetComponentsEnabled;

final class ComponentsEnabledRunnable extends AbstractRunnable
{
    public static function create() : ComponentsEnabledRunnable
    {
        return new ComponentsEnabledRunnable();
    }

    public function run(): void
    {
        $useCase = new GetComponentsEnabled();
        
        $ret = $useCase->execute();
        if (is_array($ret)) $ret = implode(PHP_EOL, $ret);
        
        echo sprintf("Componentes habilitados%s%s",
            PHP_EOL,
            $ret
        );
    }
}