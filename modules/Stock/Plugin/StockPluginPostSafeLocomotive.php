<?php

namespace modules\Stock\Plugin;

use application\AbstractPlugin;
use modules\Stock\StockFacade;
use modules\Train\Transfer\TrainTransferSegment;

/**
 * @method StockFacade getFacade()()
 */
class StockPluginPostSafeLocomotive extends AbstractPlugin implements StockPluginInterface
{
    private const ENTITY_TYPE = 'locomotive';

    public function isApplicable(TrainTransferSegment $trainSegmentTransfer): bool {
        return $trainSegmentTransfer->getSegmentType() === self::ENTITY_TYPE;
    }

    public function postSave(TrainTransferSegment $trainSegmentTransfer) {
        if($trainSegmentTransfer->getIdTrainSegment()) {
            return $this->getFacade()->getFactory()->getRepository()->increaseEntityReservation(
                $trainSegmentTransfer->getFkSegmentEntity(),
                $trainSegmentTransfer->getSegmentType()
            );
        }

        $this->getFacade()->getFactory()->getRepository()->increaseEntityReservation(
            $trainSegmentTransfer->getFkSegmentEntity(),
            $trainSegmentTransfer->getSegmentType()
        );
    }

    public function preSave(TrainTransferSegment $trainSegmentTransfer) {
        if($trainSegmentTransfer->getIdTrainSegment()) {
            return $this->getFacade()->getFactory()->getRepository()->decreaseEntityReservation(
                $trainSegmentTransfer->getFkSegmentEntity(),
                $trainSegmentTransfer->getSegmentType()
            );
        }
    }

}
