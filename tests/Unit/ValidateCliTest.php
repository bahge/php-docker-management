<?php

use Bahge\Dkman\Domain\ValidateCli\Concretes\ValidateCli;
use Bahge\Dkman\Shared\Config\CliEnumConfig;

test('Procurando o argumento nos valores do enum e retornando o nome da configuração', function() {
    $diagnostic = CliEnumConfig::tryFrom('-d')?->name;
    expect($diagnostic)->toEqual('DIAGNOSTIC');
});

test('Procurando a posição do argumento', function() {
    $argsv = ['cli.php', '-d', 'umarquivo'];
    $validateCli = new ValidateCli;
    $position = $validateCli->setArgs($argsv)->argumentsInConfig();
    expect($position[0]['position'])->toEqual(1);
});

test('Verificando se o número de argumentos são válidos para o parâmetro', function() {
    $argsv = ['cli.php', '-d', 'umarquivo'];
    $validateCli = new ValidateCli;
    $configs = $validateCli->setArgs($argsv)->argumentsInConfig();
    expect($validateCli->isValid($configs))->toBeTrue();
});

test('Verificando se o número de argumentos exigidos para o parâmetro são inválidos', function() {
    $argsv = ['cli.php', '-d'];
    $validateCli = new ValidateCli;
    $configs = $validateCli->setArgs($argsv)->argumentsInConfig();
    expect($validateCli->isValid($configs))->toBeFalse();
});

