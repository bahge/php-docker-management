<?php

namespace Bahge\Dkman\Cli;

use ReflectionClass;
use ReflectionMethod;
use Bahge\Dkman\Domain\ValidateCli\Concretes\ValidateCli;
use Bahge\Dkman\Shared\Constants\AppError;

require __DIR__ . '../../../vendor/autoload.php';

try {

    $validateCli = new ValidateCli;
    $configs = $validateCli
                    ->setArgs($argv)
                    ->argumentsInConfig();

    if ( is_array($configs) && ( $validateCli->isValid($configs) === false ) ) {
        echo createErrorMessage($configs);
        exit();
    }

    
    if (is_array($configs)) {

        for ($i=0; $i < count($configs); $i++) { 

            if (is_array($configs[$i]['config'])) 
                invokeReflection ( 
                    $configs[$i]['config']['run'], 
                    createProperties(
                        $argv, 
                        $configs[$i]['config']['properties'], 
                        $configs[$i]['position']
                    )
                );
        }
        
    } 

    
} catch (\Exception $e) {
    echo $e->getMessage();
}

/**
 * @param array<int, array<string, mixed>> $configs
 * @return string */
function createErrorMessage(array $configs): string
{

    return sprintf("%s %s %s %s",
        AppError::$CLI_IS_NOT_VALID, 
        PHP_EOL, 
        implode(PHP_EOL, 
            array_values(
                array_map(
                    function($config) {
                        if( is_array($config['config']) && is_string($config['config']['man']) ) 
                            return $config['config']['man'];
                    },
                $configs)
            )), 
        PHP_EOL
    );

}

/** @param string $run
 * @param array<string, string> $arrayProperties */
function invokeReflection(string $run, array $arrayProperties) : void
{

    $className = 'Bahge\Dkman' . $run;
    if (class_exists($className)) {

        $class = new ReflectionClass($className);
        $instance = $class->newInstance();

        foreach ($arrayProperties as $key => $property) {
            $propertyClass = $class->getProperty($key);
            $propertyClass->setValue($instance, $property);
        }

        $reflectionMethod = new ReflectionMethod($className, 'run');
        $reflectionMethod->invoke($instance);

    }
}

/** @param array<string> $argv 
 * @param array<string> $properties 
 * @param mixed $position
 * @return array<string, string> */
function createProperties(array $argv, array $properties, mixed $position) : array
{
    $arrayProperties = [];

    foreach ($properties as $key => $property) {
        $arrayProperties += [$property => $argv[$position + 1 + $key]];
    }

    return $arrayProperties;
}