<?php

namespace modules\Train\Transfer;

use Exception;

class TrainTransferSegment
{
    private ?int $idTrainSegment = null;
    private ?int $fkTrain = null;
    private ?int $fkSegmentType = null;
    private ?string $segmentType = null;
    private ?int $fkSegmentEntity = null;
    private ?int $position = null;

    /**
     * @return int|null
     */
    public function getIdTrainSegment(): ?int {
        return $this->idTrainSegment;
    }

    /**
     * @return int|null
     */
    public function getFkTrain(): ?int {
        return $this->fkTrain;
    }

    /**
     * @return int|null
     */
    public function getFkSegmentType(): ?int {
        return $this->fkSegmentType;
    }

    /**
     * @return string|null
     */
    public function getSegmentType(): ?string {
        return $this->segmentType;
    }

    /**
     * fk_locomotive or fk_wagon
     * @return string|null
     */
    public function getFkSegmentEntity(): ?string {
        return $this->fkSegmentEntity;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int {
        return $this->position;
    }

    /**
     * @return $this
     */
    public function requireIdTrainSegment(): self {
        if(!$this->idTrainSegment) { throw new Exception('Property was not set');}

        return $this;
    }

    /**
     * @return $this
     */
    public function requireFkTrain(): self {
        if(!$this->fkTrain) { throw new Exception('Property was not set');}

        return $this;
    }

    /**
     * @return $this
     */
    public function requireFkSegmentType(): self {
        if(!$this->fkSegmentType) { throw new Exception('Property was not set');}

        return $this;
    }

    /**
     * @return $this
     */
    public function requireSegmentType(): self {
        if(!$this->segmentType) { throw new Exception('Property was not set');}

        return $this;
    }


    /**
     * @return $this
     */
    public function requireFkSegmentEntity(): self {
        if(!$this->fkSegmentEntity) { throw new Exception('Property was not set');}

        return $this;
    }

    /**
     * @return $this
     */
    public function requirePosition(): self {
        if(!$this->position) { throw new Exception('Property was not set');}

        return $this;
    }

    /**
     * @return $this
     */
    public function setIdTrainSegment(int $idTrainSegment): self {
        $this->idTrainSegment = $idTrainSegment;

        return $this;
    }

    /**
     * @return $this
     */
    public function setFkTrain(int $fkTrain): self {
        $this->fkTrain = $fkTrain;

        return $this;
    }


    /**
     * @return $this
     */
    public function setFkSegmentType(int $fkSegmentType): self {
        $this->fkSegmentType = $fkSegmentType;

        return $this;
    }

    /**
     * @return $this
     */
    public function setSegmentType(string $segmentType): self {
        $this->segmentType = $segmentType;

        return $this;
    }

    /**
     * @return $this
     */
    public function setFkSegmentEntity(int $fkSegmentEntity): self {
        $this->fkSegmentEntity = $fkSegmentEntity;

        return $this;
    }

    /**
     * @return $this
     */
    public function setPosition(int $position): self {
        $this->position = $position;

        return $this;
    }

    /**
     * @param array $data
     * @param bool $ignoreMissingPropertys
     * @return $this
     */
    public function fromArray(array $data, bool $ignoreMissingPropertys = false): self {
        /*echo 'dsfdsf';
        var_dump($data);*/
        if($ignoreMissingPropertys) {
            $this->idTrainSegment = $data['idTrainSegment'] ?? null;
            $this->fkTrain = $data['fkTrain'] ?? null;
            $this->fkSegmentType = $data['fkSegmentType'] ?? null;
            $this->segmentType = $data['segmentType'] ?? null;
            $this->fkSegmentEntity = $data['segmentEntity'] ?? null;
            $this->position = $data['position'] ?? null;

            return $this;
        }

        $this->idTrainSegment = $data['idTrainSegment'] ?? null;
        $this->fkTrain = $data['fkTrain'];
        $this->fkSegmentType = $data['fkSegmentType'];
        $this->segmentType = $data['segmentType'];
        $this->fkSegmentEntity = $data['segmentEntity'];
        $this->position = $data['position'];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        return [
            'idTrainSegment' => $this->idTrainSegment,
            'fkTrain' => $this->fkTrain,
            'fkSegmentType' => $this->fkSegmentType,
            'segmentType' => $this->segmentType,
            'fkSegmentEntity' => $this->fkSegmentEntity,
            'position' => $this->position,
        ];
    }
}
