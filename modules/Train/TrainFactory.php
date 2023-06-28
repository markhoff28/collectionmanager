<?php

namespace modules\Train;

use application\AbstractController;
use application\AbstractFactory;
use modules\Locomotive\LocomotiveFacade;
use modules\Stock\StockFacade;
use modules\Train\Reader\TrainReaderDetails;
use modules\Train\Reader\TrainReader;
use modules\Train\view\TrainDetailForm;
use modules\Train\view\TrainDetailTable;
use modules\Train\view\TrainForm;
use modules\Train\Writer\TrainWriter;
use modules\Wagon\WagonFacade;
use modules\Train\view\TrainTable;

/**
 * @method TrainRepository getRepository()
 */
class TrainFactory extends AbstractFactory
{
    public function createTrainForm() {
        return new TrainForm(
            $this->getRepository()
        );
    }

    public function createTrainDetailForm() {
        return new TrainDetailForm(
            $this->getRepository()
        );
    }

    public function createTrainWriter() {
        return new TrainWriter(
            $this->getRepository(),
            $this->getPostSavePlugins()
        );
    }

    public function createTrainTable(AbstractController $abstractController) {
        return new TrainTable($this->getRepository(), $abstractController);
    }

    public function createTrainDetails(AbstractController $abstractController) {
        return new TrainDetailTable($this->getRepository(), $abstractController);
    }
    
    public function createTrainReader() {
        return new TrainReader();
    }

    public function createTrainDetailReader() {
        return new TrainReaderDetails($this->getRepository());
    }

    public function getLocomotiveFacade():LocomotiveFacade {
        return $this->getProvidedDependency(TrainDependencyProvider::FACADE_LOCOMOTIVE);
    }

    public function getStockFacade():StockFacade {
        return $this->getProvidedDependency(TrainDependencyProvider::FACADE_STOCK);
    }

    public function getWagonFacade(): WagonFacade {
        return $this->getProvidedDependency(TrainDependencyProvider::FACADE_WAGON);
    }

    public function getPostSavePlugins(): array {
        return $this->getProvidedDependency(TrainDependencyProvider::PLUGINS_POST_SAVE);
    }
}
