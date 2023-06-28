<?php

namespace application;

class AbstractFactory
{
    private ?Container $container = null;
    private string $module;


    public function __construct() {
        $this->module = $this->getModule();
    }

    public function getRepository(): AbstractRepository {
        $factory = sprintf('modules\%s\%sRepository',$this->module, $this->module);
        return new $factory;
    }

    public function getConfig() {
        $config = sprintf('modules\%s\%sConfig',$this->module, $this->module);
        return new $config;
    }

    public function getModuleName() {
        return $this->getModule();
    }

    /**
     * @param string $dependencyKey
     * @return mixed
     * @throws \Exception
     */
    public function getProvidedDependency(string $dependencyKey) {
        if($this->container === null) {
            $dependencyProviderClass = sprintf('modules\%s\%sDependencyProvider', $this->module, $this->module);
            /**
             * @var AbstractDependencyProvider $dependencyProvider
             */
            $dependencyProvider = new $dependencyProviderClass;
            $this->container = $dependencyProvider->provideDependencies(new Container());
        }

        return $this->container->get($dependencyKey)($this->container);
    }

    private function getModule() {
        return explode('\\', get_called_class()) [1];
    }

}
