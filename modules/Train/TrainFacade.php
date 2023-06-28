<?php

namespace modules\Train;

use application\AbstractFacade;

/**
 * @method TrainFactory getFactory()
*/
class TrainFacade extends AbstractFacade
{
    public function getTrains($sortColumn, $sortDirection, $searchKeyword)
    {
        return $this->getFactory()->getRepository()->getTrains($sortColumn, $sortDirection, $searchKeyword);
    }

    public function getTrainById($id, $sortColumn = 'id_train', $sortDirection = 'ASC', $searchKeyword = '')
    {
        return $this->getFactory()->getRepository()->findTrainById($id, $sortColumn, $sortDirection, $searchKeyword);
    }

    public function createTrain($data) {
        return $this->getFactory()->getRepository()->insertTrain($data);
    }

    public function updateTrain($id, $data) {
        return $this->getFactory()->getRepository()->updateTrain($id, $data);
    }

    public function deleteTrainById($id) {
        return $this->getFactory()->getRepository()->deleteTrainById($id);
    }

    public function getTrainSegmentById($id) {
        return $this->getFactory()->getRepository()->queryTrainSegmentById($id);
    }
    public function createTrainSegment($data) {
        return $this->getFactory()->getRepository()->insertTrainSegment($data);
    }

    public function updateTrainSegment($id, $data) {
        return $this->getFactory()->getRepository()->updateTrainSegment($id, $data);
    }
    public function deleteTrainSegmentById($id) {
        return $this->getFactory()->getRepository()->deleteTrainSegmentById($id);
    }

}
