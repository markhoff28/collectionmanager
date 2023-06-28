<?php

namespace modules\Wagon\view;

use application\AbstractForm;
use modules\Wagon\WagonRepository;

class WagonForm extends AbstractForm
{
    /**
     * @var WagonRepository
     */
    private $wagonRepository;

    public function __construct(WagonRepository $wagonRepository) {
        $this->wagonRepository = $wagonRepository;
    }

    function getAttributesValues($key)
    {
        return $this->wagonRepository->getAttributesValues($key);
    }

    function getCurrentDataSet(int $dataSetId)
    {
        $result = $this->wagonRepository->queryWagonByID($dataSetId);

        if ($result == null)
        {
            return [];
        }

        return (array) $result[0];
    }
}
