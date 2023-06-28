<?php

namespace modules\Train\Reader;

use modules\Train\TrainRepository;

class TrainReaderDetails
{
    private TrainRepository $trainRepository;

    /**
     * @param TrainRepository $trainRepository
     */
    public function __construct(
        TrainRepository $trainRepository
    ) {
        $this->trainRepository = $trainRepository;
    }

    public function getTrain(int $idTrain): array {
        $train = $this->trainRepository->findTrainById($idTrain);
    }

    public function setSort($sortColumn, $sortDirection = 'ASC'): void {

    }
}
