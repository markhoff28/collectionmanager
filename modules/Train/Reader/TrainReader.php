<?php

namespace modules\Train\Reader;

use application\AbstractReader;
use application\Traits\URLGeneratorTrait;
use modules\Train\TrainFacade;
use modules\Train\TrainFactory;

/**
 * @method TrainFacade getFacade()
 * @method TrainFactory getFactory
 */
class TrainReader extends AbstractReader
{
    //use URLGeneratorTrait;  Good morning in early the morning

    public function getLocomotives(array $trainData):array {
        $locomotivesData = $this->getFactory()->getLocomotiveFacade()->getLocomotives(
            'id_locomotive',
            'ASC',
            ''
        );
        $locomotives = [];
        foreach ($locomotivesData as $locomotiveData) {
            $locomotiveStock = $this->getFacade()->getFactory()->getStockFacade()->getFactory()->getRepository()->getQuantity($locomotiveData->id_locomotive, 'locomotive');

            if ($trainData[0]->fk_scale == $locomotiveData->fk_scale && $locomotiveStock[0]->stock > $locomotiveStock[0]->reserved) {
                $locomotives[] = $locomotiveData;
            }
        }
        return $locomotives;
    }

    public function getWagons(array $trainData):array  {
         $wagonsData = $this->getFactory()->getWagonFacade()->getWagons(
            'id_wagon',
            'ASC',
            ''
        );
         $wagons = [];
        foreach ($wagonsData as $wagonData) {
            $wagonStock = $this->getFacade()->getFactory()->getStockFacade()->getFactory()->getRepository()->getQuantity($wagonData->id_wagon, 'wagon');

            if ($trainData[0]->fk_scale == $wagonData->fk_scale && $wagonStock[0]->stock > $wagonStock[0]->reserved) {
                $wagons[] = $wagonData;
            }
        }
         return $wagons;
    }

    public function generateTrain($idTrain):array {
        $trainStructure = $this->getFacade()->getTrainById($idTrain);
        $train = [];
        foreach ($trainStructure as $value) {
            if ($value->type == 'lokomotive') {
                $locomotive = $this->getFactory()->getLocomotiveFacade()->getLocomitiveById($value->fk_segmentEntity);
                $train[$value->position] = (object) array_merge((array) $value, (array) $locomotive[0]);
            }
            if ($value->type == 'wagon') {
                $wagon = $this->getFactory()->getWagonFacade()->getWagonById($value->fk_segmentEntity);
                $train[$value->position] = (object) array_merge((array) $value, (array) $wagon[0]);
            }
        }
        return $train;
    }

}
