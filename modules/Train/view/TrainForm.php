<?php

namespace modules\Train\view;

use application\AbstractForm;
use modules\Train\TrainRepository;

class TrainForm extends AbstractForm
{
    /**
     * @var TrainRepository
    */
    private $trainRepository;

    public function __construct (TrainRepository $trainRepository) {
        $this->trainRepository = $trainRepository;
    }

    function getAttributesValues($key)
    {
        return $this->trainRepository->getAttributesValues($key);
    }

    function getCurrentDataSet(int $dataSetId)
    {
        $result = $this->trainRepository->findTrainById($dataSetId);

        if ($result == null)
        {
            return [];
        }

        return (array) $result[0];
    }
}
