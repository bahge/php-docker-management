<?php

declare(strict_types=1);

namespace Bahge\Dkman\Domain\Diagnostic\UseCase\Concretes;

use Bahge\Dkman\Domain\Diagnostic\ComponentsEnabled\ComponentsEnabled;
use Bahge\Dkman\Domain\Diagnostic\UseCase\Interfaces\IDiagnostic;
use Bahge\Dkman\Shared\Constants\AppError;
use Exception;

final class Diagnostic implements IDiagnostic
{
    private string $path;
    private string $content;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    /** @return array<string> | string */
    public function execute(): array | string
    {
        try {

            if ( $this->headerIsValid() !== true ) return AppError::$HEADER_NOT_VALID;
            $components = $this->getComponents(); 

            if ($components == []) {
                return AppError::$IMAGE_NOT_VALID;
            }
            return $components;
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /** @return bool */
    public function fileExists() : bool
    {
        if (file_exists($this->path) === true) return true;
        
        throw new Exception(AppError::$FILE_NOT_FOUND);
    }

    /** @return string */
    private function readContent() : string
    {
        $this->content = '';
        $content = file_get_contents($this->path);
        if ($content != false) $this->content = $content;
        return $this->content;
    }

    /** @return bool */
    public function headerIsValid() : bool
    {
        if ($this->fileExists() === true) $this->readContent();

        if ( 
            ( strlen($this->content) > 11) 
            && ( str_contains( $this->content, ComponentsEnabled::$DOCKER_COMPOSE_VERSION) ) 
            ) return true;
        return false;
    }

    /** @return array<string> */
    public function getComponents() : array
    {
        $this->readContent();

        preg_match_all(
            '/(image: )(.*?)(\n)/',
            $this->getContent(),
            $matches, 
            PREG_SET_ORDER);
        
        if (empty($matches)) throw new Exception(AppError::$IMAGE_NOT_FOUND);

        $components = [];
        foreach ($matches as $key => $images) {
            if (isset($images[2])) array_push($components, $images[2]);
        }

        $componetsFounded = [];
        foreach ($components as $component) {
            foreach (ComponentsEnabled::$LIST_COMPONENTS as $componentEnabled) {
                if (strstr($component, $componentEnabled) != false) array_push($componetsFounded, $componentEnabled);
            }
        }

        if (count($components) > count($componetsFounded)) return [];

        return $componetsFounded;
    }

    /** @return string */
    public function getContent() : string
    {
        return $this->content;
    }
}
