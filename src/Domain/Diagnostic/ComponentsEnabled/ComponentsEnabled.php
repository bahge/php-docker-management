<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Diagnostic\ComponentsEnabled;

final class ComponentsEnabled
{

    /** @var string */
    public static string $DOCKER_COMPOSE_VERSION = "version: \"3.8\"";

    /** @var array<string> */
    public static array $LIST_COMPONENTS = [
        'php8.1-fpm',
        'nginx:alpine',
        'mongo:5.0',
        'mongo-express',
        'rabbitmq:3.8.25-management-alpine'
    ];
}