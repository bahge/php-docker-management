<?php

use Bahge\Dkman\Domain\Standart\Header\HeaderPart;
use Bahge\Dkman\Domain\Components\Php\PhpComponent;
use Bahge\Dkman\Domain\Standart\Networks\NetworksPart;
use Bahge\Dkman\Domain\Components\Mongo\MongoComponent;
use Bahge\Dkman\Domain\Components\Nginx\NginxComponent;
use Bahge\Dkman\Domain\ValidateCli\Concretes\ValidateCli;
use Bahge\Dkman\Domain\Components\Rabbitmq\RabbitmqComponent;
use Bahge\Dkman\Domain\Components\MongoExpress\MongoExpressComponent;

require_once("../vendor/autoload.php");

// $network = "fusion-arch-network";
// $projectName = "fusion-arch";
// $appPort = 8011;

// $header = new HeaderPart;
// $networkPart = new NetworksPart;

// $php = new PhpComponent;
// $php->setStandart($projectName, $network);

// $nginx = new NginxComponent;
// $nginx->setStandart($projectName, $network, $appPort);

// $mongo = new MongoComponent;
// $mongo->setStandart($projectName, $network);

// $mongoExpress = new MongoExpressComponent;
// $mongoExpress->setStandart($projectName, $network);

// $rabbitmq = new RabbitmqComponent;
// $rabbitmq->setStandart($projectName, $network);

// echo "Versões:" . PHP_EOL;
// echo $php::$IMAGE;
// echo PHP_EOL;
// echo $nginx::$IMAGE;
// echo PHP_EOL;
// echo $mongo::$IMAGE;
// echo PHP_EOL;
// echo $mongoExpress::$IMAGE;
// echo PHP_EOL;
// echo $rabbitmq::$IMAGE;
// echo PHP_EOL;
// echo PHP_EOL;
// echo ".env.cfg";
// echo PHP_EOL . "# PHP" . PHP_EOL;
// echo $php->getEnvFormated($php->getEnvDocker());
// echo PHP_EOL . "# NGINX" . PHP_EOL;
// echo $nginx->getEnvFormated($nginx->getEnvDocker());
// echo PHP_EOL . "# Mongo" . PHP_EOL;
// echo $mongo->getEnvFormated($mongo->getEnvDocker());
// echo PHP_EOL . "# Mongo Express" . PHP_EOL;
// echo $mongoExpress->getEnvFormated($mongoExpress->getEnvDocker());
// echo PHP_EOL . "# Rabbitmq" . PHP_EOL;
// echo $rabbitmq->getEnvFormated($rabbitmq->getEnvDocker());

// echo PHP_EOL;
// echo ".env.dev";
// echo PHP_EOL;
// echo $php->getEnvFormated($php->getEnvInternalConfig());
// echo $nginx->getEnvFormated($nginx->getEnvInternalConfig());
// echo $mongo->getEnvFormated($mongo->getEnvInternalConfig());
// echo $mongoExpress->getEnvFormated($mongoExpress->getEnvInternalConfig());
// echo $rabbitmq->getEnvFormated($rabbitmq->getEnvInternalConfig());
// echo PHP_EOL;
// echo $header->getStandart();
// echo $php->getDockerCompose();
// echo $nginx->getDockerCompose();
// echo $networkPart->getStandart($network);
// echo PHP_EOL;
// echo $header->getStandart();
// echo $mongo->getDockerCompose();
// echo $mongoExpress->getDockerCompose();
// echo $rabbitmq->getDockerCompose();
// echo $networkPart->getStandart($network);

$argsv = ['cli.php', '-d', 'umarquivo'];
$validateCli = new ValidateCli;
$configs = $validateCli->setArgs($argsv)->argumentsInConfig();
//$validateCli->totalArgumentsNecessary($configs);