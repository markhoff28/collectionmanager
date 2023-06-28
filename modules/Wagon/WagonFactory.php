<?php

namespace modules\Wagon;

use application\AbstractController;
use application\AbstractFactory;
use modules\Locomotive\LocomotiveFacade;
use modules\Wagon\view\WagonDelete;
use modules\Wagon\view\WagonDetails;
use modules\Wagon\view\WagonTable;
use modules\Wagon\view\WagonForm;

/**
 * @method WagonRepository getRepository()
 */
class WagonFactory extends AbstractFactory
{
    public function createWagonForm() {
        /*$this->getLocomotiveFacade();
        var_dump($this->getLocomotiveFacade()->getLocomitiveById(1));*/

        return new WagonForm(
            $this->getRepository()
        );
    }

    public function createWagonTable(AbstractController $abstractController) {
        return new WagonTable($this->getRepository(), $abstractController);
    }

    public function createWagonDetail() {
        return new WagonDetails($this->getDetailPlugins());
    }

    public function createWagonDelete() {
        return new WagonDelete();
    }

    public function getLocomotiveFacade():LocomotiveFacade {
        return $this->getProvidedDependency(WagonDependencyProvider::FACADE_LOCOMOTIVE);
    }

    public function getDetailPlugins(): array {
        return $this->getProvidedDependency(WagonDependencyProvider::PLUGINS_DETAILS);
    }
}
