<?php

namespace modules\Locomotive\view;

use application\AbstractForm;
use modules\Locomotive\LocomotiveRepository;

class LocomotiveForm extends AbstractForm
{
    /**
     * @var LocomotiveRepository
     */
    private $locomotiveRepository;

    public function __construct(LocomotiveRepository $locomotiveRepository) {
        $this->locomotiveRepository = $locomotiveRepository;
    }

    function getAttributesValues($key)
    {
        return $this->locomotiveRepository->getAttributesValues($key);
    }

    function getCurrentDataSet(int $dataSetId)
    {
        $result = $this->locomotiveRepository->queryLocomotiveByID($dataSetId);

        if ($result == null)
        {
            return [];
        }

        return (array) $result[0];
    }
}
