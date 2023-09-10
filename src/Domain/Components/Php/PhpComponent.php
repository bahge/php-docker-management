<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components\Php;

use Bahge\Dkman\Domain\Components\AbstractComponent;

final class PhpComponent extends AbstractComponent
{
    public static string $IMAGE = "php8.1-fpm";

    /** @param string $projectName
     * @param string $network
     * @return PhpComponent */
    public function setStandart(string $projectName, string $network): PhpComponent
    {
        parent::setNetwork($network);

        parent::setDockerCompose(
            sprintf("
    # PHP service
    app:
        build:
            context: ./docker/%s
            dockerfile: Dockerfile.\${ENVIRONMENT}
        container_name: %s-php
        working_dir: /var/www/
        ports:
            - \"9000:9000\"
        volumes:
            - \"\${VOLUME_APP}:/var/www\"
        networks:
            - %s
        extra_hosts:
            - \"host.docker.internal:host-gateway\"
",
            self::$IMAGE,
            $projectName,
            parent::getNetwork())
        );

        parent::setEnvDocker([
            ['key' => 'ENVIRONMENT', 'value' => 'dev'],
            ['key' => 'VOLUME_APP', 'value' => './app']
        ]);

        parent::setEnvInternalConfig([]);
        
        return $this;
    }
}