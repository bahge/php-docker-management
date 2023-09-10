<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\ValidateCli\Concretes;

use Exception;
use ReflectionClass;
use Bahge\Dkman\Shared\Config\CliEnumConfig;
use Bahge\Dkman\Domain\ValidateCli\Interfaces\IValidateCli;

final class ValidateCli implements IValidateCli
{
    /** @var array<string> */
    private array $args;

    /** @param array<string> $args
     * @return $this */
    public function setArgs(array $args) : ValidateCli
    {
        $this->args = $args;
        return $this;
    }

    /** @param int $numberArguments
     * @return bool*/
    public function hasArguments(int $numberArguments) : bool
    {
        if ($numberArguments > 1) return true;
        return false;
    }

    /** @return array<int, array<string, mixed>> */
    public function argumentsInConfig() : array
    {     
        $configs = [];
        foreach ($this->args as $argument) {
            $config = CliEnumConfig::tryFrom($argument)?->name;
            $class = new ReflectionClass('Bahge\Dkman\Shared\Config\CliConfigs');
            $position = array_search($argument, $this->args);
            if ($position != false && !is_null($config)) array_push($configs, ['position' => $position, 'config' => $class->getStaticPropertyValue($config)]);
        }

        if ($configs != []) return $configs;
        throw new Exception("Nenhum argumento válido foi encontrado, verifique o -man");
    }

    /** @param array<int, array<string, mixed>> $configs
     * @return bool*/
    public function isValid(array $configs) : bool
    {
        $totalArgs = count($this->args) - 1;
        if ($totalArgs == $this->totalArgumentsNecessary($configs)) return true;
        return false;
    }
    
    /** @param array<int, array<string, mixed>> $configs
     * @return int*/
    private function totalArgumentsNecessary(array $configs) : int
    {
        return array_reduce($configs, function($carry, $config) {
            if ( is_array($config) && is_array($config['config']) ) $carry += $config['config']['args'];
            return $carry;
        }, 0);
    }

}