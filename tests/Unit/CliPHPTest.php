<?php

/**
 * Passos:
 * 1. Verifica se foi passado argumentos
 * 2. Se passado argumentos, verifica se os argumentos são válidos
 * 3. Se os argumentos são válidos executa o caso de uso do Runnable
 * 4. Verifica se o caso de uso do Runnable teve o retorno esperado
 */

use Bahge\Dkman\Shared\Constants\AppError;
use Bahge\Dkman\Domain\ValidateCli\Concretes\ValidateCli;

test('Verifica se foi enviado parâmetros para o cli.php', function() {
    $argc = 1;
    $validateCli = new ValidateCli;
    expect($validateCli->hasArguments($argc))->toBeFalse();
    $argc = 2;
    expect($validateCli->hasArguments($argc))->toBeTrue();
});

test('Verifica os argumentos correspondem a alguma config e se são válidos', function() {
    $argc = 1;
    $validateCli = new ValidateCli;
    expect($validateCli->hasArguments($argc))->toBeFalse();

    $argc = 2;
    $argv = ['cli.php', '-d'];
    expect($validateCli->hasArguments($argc))->toBeTrue();
    $configs = $validateCli->setArgs($argv)->argumentsInConfig();
    expect($validateCli->isValid($configs))->toBeFalse();

    $argc = 3;
    $argv = ['cli.php', '-d', 'path'];
    expect($validateCli->hasArguments($argc))->toBeTrue();
    $configs = $validateCli->setArgs($argv)->argumentsInConfig();
    expect($validateCli->isValid($configs))->toBeTrue();
});

test('Executa o caso de uso através da ReflectionClass', function() {
    $argc = 3;
    $argv = ['cli.php', '-d', 'path'];
    
    $validateCli = new ValidateCli;
    expect($validateCli->hasArguments($argc))->toBeTrue();

    $configs = $validateCli->setArgs($argv)->argumentsInConfig();
    if (is_array($configs) && is_array($configs[0]['config'])) $useCase = $configs[0]['config']['useCase'];

    $class = new ReflectionClass('Bahge\Dkman' . $useCase);
    $instance = $class->newInstance($argv[2]);

    $reflectionMethod = new ReflectionMethod('Bahge\Dkman' . $useCase, 'execute');

    expect($reflectionMethod->invoke($instance))->toEqual(AppError::$FILE_NOT_FOUND);
});