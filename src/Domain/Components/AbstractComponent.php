<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Components;

abstract class AbstractComponent
{
    /** @var string */
    private string $network;

    /** @var array<int, array<string, int|string>> */
    private array $envDocker;

    /** @var array<int, array<string, int|string>> */
    private array $envConfig;

    /** @var string */
    private string $dockerCompose;

    /** @return string */
    public function getNetwork(): string
    {
        return $this->network;
    }

    /** @return AbstractComponent */
    public function setNetwork(string $network):AbstractComponent
    {
        $this->network = $network;

        return $this;
    }

    /** @return array<int, array<string, int|string>> */
    public function getEnvDocker():array
    {
        return $this->envDocker;
    }

    /** 
     * @param array<int, array<string, int|string>> $envDocker 
     * @return AbstractComponent */
    public function setEnvDocker(array $envDocker = []): AbstractComponent
    {
        $this->envDocker = $envDocker;

        return $this;
    }

    /** @return array<int, array<string, int|string>> */
    public function getEnvInternalConfig():array
    {
        return $this->envConfig;
    }

    /** 
     * @param array<int, array<string, int|string>> $envConfig 
     * @return AbstractComponent */
    public function setEnvInternalConfig(array $envConfig = []): AbstractComponent
    {
        $this->envConfig = $envConfig;

        return $this;
    }

    /** @return string */
    public function getDockerCompose():string
    {
        return $this->dockerCompose;
    }

    /** @return AbstractComponent */
    public function setDockerCompose(string $dockerCompose):AbstractComponent
    {
        $this->dockerCompose = $dockerCompose;

        return $this;
    }

    /** 
     * @param array<int, array<string, int|string>> $env 
     * @return string */
    public function getEnvFormated(array $env):string
    {
        $strFormated = '';

        if (empty($env)) return $strFormated;

        foreach($env as $envValue)
        {
            $strFormated .= sprintf(
                "%s=%s\n", 
                $envValue['key'], 
                $envValue['value']
            );
        }
        return $strFormated;
    }
}