<?php

namespace modules\Train\view;

use application\AbstractForm;
use modules\Train\TrainRepository;
use modules\Train\Transfer\TrainTransferSegment;

class TrainDetailForm extends AbstractForm
{
    /**
     * @var TrainRepository
     */
    private $trainRepository;

    public function __construct (TrainRepository $trainRepository) {
        $this->trainRepository = $trainRepository;
    }

    public function getAttributesValues($key)
    {
        return $this->trainRepository->getAttributesValues($key);
    }

    public function getCurrentDataSet(int $dataSetId)
    {
        $result = $this->trainRepository->findTrainById($dataSetId);

        if ($result == null)
        {
            return [];
        }

        return (array) $result[0];
    }

    public function getFormValues(): array
    {
        $formValues = [];

        foreach ($this->getFormConfig() as $key => $config) {

            if (!empty($_POST[$key]) && $_POST[$key] != 'empty') {
                $formValues[$config['columnName']] = intval($_POST[$key]);
                if (!empty($config['tableId'])) {
                    $formValues['fkSegmentType'] = intval($config['tableId']);
                    $formValues['segmentType'] = $key;
                    $formValues['fkSegmentEntity'] = intval($config['tableId']);
                }
            }
        }

        return $formValues;
    }

    public function getFormConfig() {
        return [
            'fkZug' => [
                'columnName' => 'fkZug',
            ],
            'locomotive' => [
                'columnName' => 'segmentEntity',
                'tableId' => '1',
            ],
            'wagon' => [
                'columnName' => 'segmentEntity',
                'tableId' => '2',
            ],
        ];
    }

}
