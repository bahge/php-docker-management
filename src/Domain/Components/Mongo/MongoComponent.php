<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components\Mongo;

use Bahge\Dkman\Domain\Components\AbstractComponent;

final class MongoComponent extends AbstractComponent
{
    public static string $IMAGE = "mongo:5.0";

    /** @param string $projectName
     * @param string $network
     * @return MongoComponent */
    public function setStandart(string $projectName, string $network): MongoComponent
    {
        parent::setNetwork($network);

        parent::setDockerCompose(
            sprintf("
    # Mongo database service
    mongo:
        image: %s
        container_name: %s-mongo-infra-local
        hostname: mongodb
        environment:
            MONGO_INITDB_ROOT_USERNAME: \${DB_MONGO_USERNAME}
            MONGO_INITDB_ROOT_PASSWORD: \${DB_MONGO_PASSWORD}
        env_file:
            - ./.env
        restart: \"unless-stopped\"
        ports:
            - \"\${PORT_MONGO}:\${PORT_MONGO}\"
        volumes:
            - \"\${VOLUME_MONGO_DB}/db:/data/db\"
            - \"\${VOLUME_MONGO_DB}/dev.archive:/Databases/dev.archive\"
            - \"\${VOLUME_MONGO_DB}/production:/Databases/production\"
        networks:
            - %s
",
            self::$IMAGE,
            $projectName, 
            parent::getNetwork())
        );

        parent::setEnvDocker([
            ['key' => 'PORT_MONGO', 'value' => 27017],
            ['key' => 'VOLUME_MONGO_DB', 'value' => './database/mongodb'],
            ['key' => 'DB_MONGO_USERNAME', 'value' => 'root'],
            ['key' => 'DB_MONGO_PASSWORD', 'value' => 'pass']
        ]);

        parent::setEnvInternalConfig([
            ['key' => 'PORT_MONGO', 'value' => 27017],
            ['key' => 'DB_MONGO_USERNAME', 'value' => 'root'],
            ['key' => 'DB_MONGO_PASSWORD', 'value' => 'pass']
        ]);
        
        return $this;
    }
}
