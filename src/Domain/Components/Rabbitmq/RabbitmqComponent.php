<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components\Rabbitmq;

use Bahge\Dkman\Domain\Components\AbstractComponent;

final class RabbitmqComponent extends AbstractComponent
{
    public static string $IMAGE = "rabbitmq:3.8.25-management-alpine";

    /** @param string $projectName
     * @param string $network
     * @return RabbitmqComponent */
    public function setStandart(string $projectName, string $network): RabbitmqComponent
    {
        parent::setNetwork($network);

        parent::setDockerCompose(
            sprintf("
    # Rabbitmq service
    rabbitmq:
        image: %s
        container_name: %s-rabbitmq-infra-local
        hostname: rabbitmq
        environment:
            RABBITMQ_DEFAULT_USER: \${RABBITMQ_USERNAME}
            RABBITMQ_DEFAULT_PASS: \${RABBITMQ_PASSWORD}
        env_file:
            - ./.env
        restart: \"unless-stopped\"
        ports:
            - \"\${RABBITMQ_PORT}:\${RABBITMQ_PORT}\"
            - \"\${RABBITMQ_MANAGER_PORT}:\${RABBITMQ_MANAGER_PORT}\"
        volumes:
            - \"\${VOLUME_RABBITMQ}/data/:/var/lib/rabbitmq/\"
            - \"\${VOLUME_RABBITMQ}/log/:/var/log/rabbitmq/\"
        networks:
            - %s
",
            self::$IMAGE,
            $projectName, 
            parent::getNetwork())
        );

        parent::setEnvDocker([
            ['key' => 'RABBITMQ_USERNAME', 'value' => 'rabbit'],
            ['key' => 'RABBITMQ_PASSWORD', 'value' => 'pass'],
            ['key' => 'RABBITMQ_PORT', 'value' => 5672],
            ['key' => 'RABBITMQ_MANAGER_PORT', 'value' => 15672],
            ['key' => 'VOLUME_RABBITMQ', 'value' => './volumes/rabbitmq/']
        ]);

        parent::setEnvInternalConfig([
            ['key' => 'RABBITMQ_PORT', 'value' => 5672],
            ['key' => 'RABBITMQ_USERNAME', 'value' => 'rabbit'],
            ['key' => 'RABBITMQ_PASSWORD', 'value' => 'pass']
        ]);
        
        return $this;
    }
}