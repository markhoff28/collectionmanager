<?php

namespace application;

class AbstractFacade
{
    public function getFactory() {
        $moduleName = $this->getModule();
        $factory = sprintf('modules\%s\%sFactory',$moduleName, $moduleName);
        return new $factory;
    }

    private function getModule() {
        return explode('\\', get_called_class()) [1];
    }
}
