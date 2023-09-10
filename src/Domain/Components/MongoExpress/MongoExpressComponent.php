<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components\MongoExpress;

use Bahge\Dkman\Domain\Components\AbstractComponent;

final class MongoExpressComponent extends AbstractComponent
{
    public static string $IMAGE = "mongo-express";

    /** @param string $projectName
     * @param string $network
     * @return MongoExpressComponent */
    public function setStandart(string $projectName, string $network): MongoExpressComponent
    {
        parent::setNetwork($network);

        parent::setDockerCompose(
            sprintf("
    # Mongo Express service
    mongo-express:
        image: %s
        container_name: %s-mexpress-infra-local
        environment:
            ME_CONFIG_MONGODB_ADMINUSERNAME: \${DB_MONGO_USERNAME}
            ME_CONFIG_MONGODB_ADMINPASSWORD: \${DB_MONGO_PASSWORD}
            ME_CONFIG_MONGODB_URL: \"mongodb://\${DB_MONGO_USERNAME}:\${DB_MONGO_PASSWORD}@mongo:\${PORT_MONGO}/?authSource=admin\"
            ME_CONFIG_BASICAUTH_USERNAME: \${MEXPRESS_USERNAME}
            ME_CONFIG_BASICAUTH_PASSWORD: \${MEXPRESS_PASSWORD}
        env_file:
            - ./.env
        links:
            - mongo
        restart: \"unless-stopped\"
        ports:
            - \"\${PORT_MONGO_EXPRESS}:\${PORT_MONGO_EXPRESS}\"
        networks:
            -  %s
",
            self::$IMAGE,
            $projectName, 
            parent::getNetwork())
        );

        parent::setEnvDocker([
            ['key' => 'PORT_MONGO_EXPRESS', 'value' => 8015],
            ['key' => 'MEXPRESS_USERNAME', 'value' => 'mexpress'],
            ['key' => 'MEXPRESS_PASSWORD', 'value' => 'pass']
        ]);

        parent::setEnvInternalConfig([]);
        
        return $this;
    }
}
