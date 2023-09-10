<?php

declare(strict_types=1);

namespace Bahge\Dkman\Cli\Concretes;

use Bahge\Dkman\Cli\Interfaces\AbstractRunnable;
use Bahge\Dkman\Domain\Diagnostic\UseCase\Concretes\Diagnostic;

class DiagnosticRunnable extends AbstractRunnable
{
    private string $path;

    public static function create() : DiagnosticRunnable
    {
        return new DiagnosticRunnable();
    }

    public function setPath(string $path) : DiagnosticRunnable
    {
        $this->path = $path;
        return $this;
    }

    public function run(): void
    {
        $useCase = new Diagnostic($this->path);
        $ret = $useCase->execute();
        if (is_array($ret)) $ret = implode(PHP_EOL, $ret);
        
        echo sprintf("Diagnóstico%s%s",
            PHP_EOL,
            $ret
        );
    }
}
