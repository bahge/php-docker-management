<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components\Nginx;

use Bahge\Dkman\Domain\Components\AbstractComponent;

final class NginxComponent extends AbstractComponent
{
    public static string $IMAGE = "nginx:alpine";

    /** @param string $projectName
     * @param string $network
     * @param int $appPort
     * @return NginxComponent */
    public function setStandart(string $projectName, string $network, int $appPort): NginxComponent
    {
        parent::setNetwork($network);

        parent::setDockerCompose(
            sprintf("
    # Nginx service
    nginx:
        image: %s
        container_name: %s-nginx
        ports:
            - \"\${APP_PORT}:80\"
        volumes:
            - \"\${VOLUME_APP}:/var/www\"
            - \"\${VOLUME_NGINX_CONFIG}:/etc/nginx/conf.d/\"
        networks:
            - %s",
            self::$IMAGE,
            $projectName,
            parent::getNetwork())
        );

        parent::setEnvDocker([
            ['key' => 'APP_PORT', 'value' => $appPort],
            ['key' => 'VOLUME_NGINX_CONFIG', 'value' => './docker/nginx/conf.d/']
        ]);

        parent::setEnvInternalConfig([]);
        
        return $this;
    }
}