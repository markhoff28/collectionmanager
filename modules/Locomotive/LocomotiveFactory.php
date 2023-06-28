<?php

namespace modules\Locomotive;

use application\AbstractController;
use application\AbstractFactory;
use modules\Locomotive\view\LocomotiveDetails;
use modules\Locomotive\view\LocomotiveTable;
use modules\Locomotive\view\LocomotiveForm;
use modules\Stock\StockFacade;
use modules\Wagon\WagonFacade;

/**
 * @method LocomotiveRepository getRepository()
 */
class LocomotiveFactory extends AbstractFactory
{
    public function createLocomotiveForm() {
        return new LocomotiveForm(
            $this->getRepository()
        );
    }

    public function createLocomotiveTable(AbstractController $abstractController) {
        return new LocomotiveTable($this->getRepository(), $abstractController);
    }

    public function createLocomotiveDetails() {
        return new LocomotiveDetails($this->getDetailPlugins());
    }

    public function getWagonFacade(): WagonFacade {
        return $this->getProvidedDependency(LocomotiveDependencyProvider::FACADE_WAGON);
    }

    public function getDetailPlugins(): array {
        return $this->getProvidedDependency(LocomotiveDependencyProvider::PLUGINS_DETAILS);
    }
}
