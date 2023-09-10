<?php

/**
 * Desafio
 * 1 Normatizar os meus ambientes de desenvolvimento local;
 * R: 1.1. Qual o ambiente que eles estão usando?
 * R: 1.2. Esse ambiente tem services habilitado? Elegidos como standart?
 * R: 1.3. Posso criar um ambiente como os services, porém usando os habilitados?
 * --> Domain -> Diagnostic
 * 
 * 2 Desenvolver uma solução que crie de forma padronizada e apenas com services, habilitados.
 * R: 2.1. Lista de services habilitados;
 * R: 2.2. Aplicação que por seleção me entregue os docker-compose e os .env, necessários para execução.
 */


use Bahge\Dkman\Domain\ValidateCli\Concretes\ValidateCli;

require_once('./vendor/autoload.php');

// $diagnostic = new ValidateCli;
// $config = $diagnostic->setArgs($argv)->argumentsInConfig();
// if ( $diagnostic->isValid($config) === false 
//         && is_array($config) 
//         && is_array($config[0]['config'])
//     ) echo $config[0]['config']['run'];

try {
    $validateCli = new ValidateCli;
    $configs = $validateCli->setArgs($argv)->argumentsInConfig();
    if (is_array($configs) && is_array($configs[0]['config'])) $run = $configs[0]['config']['run'];
    if (is_array($configs) && is_array($configs[0]['config'])) $args = $configs[0]['config']['args'];
    if (is_array($configs)) $position = $configs[0]['position'];
    if ( ($args - $position) == 1 ) $position = $position + 1;
    $class = new ReflectionClass('Bahge\Dkman' . $run);
    $instance = $class->newInstance();
    $property = $class->getProperty('path');
    $property->setValue($instance, $argv[2]);
    
    $reflectionMethod = new ReflectionMethod('Bahge\Dkman' . $run, 'run');
    $reflectionMethod->invoke($instance);
} catch (\Exception $e) {
    echo $e->getMessage();
}
