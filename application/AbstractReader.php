<?php

namespace application;

abstract class AbstractReader
{
    public function getFactory() {
        $moduleName = $this->getModule();
        $factory = sprintf('modules\%s\%sFactory',$moduleName, $moduleName);
        return new $factory;
    }

    public function getFacade() {
        $moduleName = $this->getModule();
        $facade = sprintf('modules\%s\%sFacade',$moduleName, $moduleName);
        return new $facade;
    }

    private function getModule() {
        $moduleName = explode('\\', get_called_class()) [1];
        return $moduleName;
    }
}
