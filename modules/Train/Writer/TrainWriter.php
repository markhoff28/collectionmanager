<?php

namespace modules\Train\Writer;

use modules\Train\TrainRepository;
use modules\Train\Transfer\TrainTransferSegment;

class TrainWriter
{
    private TrainRepository $trainRepository;
    private array $postSavePlugins;

    /**
     * @param TrainRepository $trainRepository
     * @param array $postSavePlugins
     */
    public function __construct(
        TrainRepository $trainRepository,
        array $postSavePlugins
    )
    {
        $this->trainRepository = $trainRepository;
        $this->postSavePlugins = $postSavePlugins;
    }

    public function addSegment(TrainTransferSegment $trainSegmentTransfer): bool {
        try {
            $result = $this->trainRepository->insertTrainSegment($trainSegmentTransfer);

            foreach($this->postSavePlugins as $postSavePlugin) {
                if($postSavePlugin->isApplicable($trainSegmentTransfer)) {
                    $postSavePlugin->postSave($trainSegmentTransfer);
                }
            }
        } catch (\Exception $exception) {
            return false;
        }

        return $result;
    }

    public function updateSegment(
        TrainTransferSegment $trainSegmentTransfer,
        TrainTransferSegment $oldTrainSegmentTransfer
    ): bool
    {
        try {
            $result = $this->trainRepository->updateTrainSegment2($trainSegmentTransfer);

            foreach($this->postSavePlugins as $postSavePlugin) {
                if($postSavePlugin->isApplicable($oldTrainSegmentTransfer)) {
                    $postSavePlugin->preSave($oldTrainSegmentTransfer);
                }
                if($postSavePlugin->isApplicable($trainSegmentTransfer)) {
                    $postSavePlugin->postSave($trainSegmentTransfer);
                }
            }
        } catch (\Exception $exception) {
            return false;
        }

        return $result;
    }

    public function removeSegment(TrainTransferSegment $trainSegmentTransfer): bool {
        try {
            $result = $this->trainRepository->deleteTrainSegmentById($trainSegmentTransfer->getIdTrainSegment());

            foreach($this->postSavePlugins as $postSavePlugin) {

                if($postSavePlugin->isApplicable($trainSegmentTransfer)) {
                    var_dump($trainSegmentTransfer);
                    $postSavePlugin->preSave($trainSegmentTransfer);
                }
            }

        } catch (\Exception $exception) {
            return false;
        }

        return $result;
    }


}
