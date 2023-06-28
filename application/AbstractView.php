<?php

namespace application;

abstract class AbstractView
{
    public function getConfig() {
        $moduleName = $this->getModule();
        $configFile = sprintf('modules\%s\%sConfig',$moduleName, $moduleName);
        $config = new $configFile;
        if(is_callable([$config, 'getConfig'])) {
            return $config->getConfig();
        }
        throw new \Exception('Config not found');
    }

    public function getModuleName() {
        return $this->getModule();
    }

    private function getModule() {
        return explode('\\', get_called_class()) [1];
    }

    // Constuctor Header, Deconstructor footer Alles weitere die View
}