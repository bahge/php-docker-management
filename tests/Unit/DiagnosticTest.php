<?php

use Bahge\Dkman\Domain\Diagnostic\UseCase\Concretes\Diagnostic;
use Bahge\Dkman\Shared\Constants\AppError;

test('Arquivo existente: encontrado o docker-compose.dev.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.dev.yaml');
    expect($diag->fileExists())->toBeTrue();
});

test('Arquivo inexistente: não encontrado o docker-comp.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-comp.yaml');
    expect(fn() => $diag->fileExists())->toThrow(AppError::$FILE_NOT_FOUND);
});

test('Arquivo válido: o docker-compose.dev.yaml tem o header contratuado', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.dev.yaml');
    expect($diag->headerIsValid())->toBeTrue();
});

test('Arquivo inválido: o docker-compose.dev.yaml tem o header contratuado', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.yaml');
    expect($diag->headerIsValid())->toBeFalse();
});

test('Há imagens dos componentes no docker-compose.dev.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.dev.yaml');
    $components = $diag->getComponents();
    expect($components)->toHaveCount(3);
});

test('Não há imagens de componentes no docker-compose.mock.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.mock.yaml');
    expect(fn() => $diag->getComponents())->toThrow(AppError::$IMAGE_NOT_FOUND);
});

test('Há imagens dos componentes no docker-compose.dev.yaml e são: rabbitmq, mongo, mongo-express', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.dev.yaml');
    $components = $diag->getComponents();
    expect($components)->toEqual(['rabbitmq:3.8.25-management-alpine', 'mongo:5.0', 'mongo-express']);
});

test('Há imagens dos componentes no docker-compose.yaml, porém não são válidas', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.yaml');
    $components = $diag->getComponents();
    expect($diag->headerIsValid())->toBeFalse();
    expect($components)->toBeArray();
});

test('Método execute retorna valores válidos do docker-compose.dev.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.dev.yaml');
    expect($diag->execute())->toEqual(['rabbitmq:3.8.25-management-alpine', 'mongo:5.0', 'mongo-express']);
});

test('Método execute retorna que o arquivo não foi encontrado docker-comp.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-comp.yaml');
    expect($diag->execute())->toEqual(AppError::$FILE_NOT_FOUND);
});

test('Método execute retorna que o arquivo não possui a versão correta, docker-compose.yaml', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.yaml');
    expect($diag->execute())->toEqual(AppError::$HEADER_NOT_VALID);
});

test('Método execute retorna que o arquivo não possui componentes habilitados', function() {
    $diag = new Diagnostic(__DIR__ . '/docker-compose.prod.yaml');
    expect($diag->execute())->toEqual(AppError::$IMAGE_NOT_VALID);
});