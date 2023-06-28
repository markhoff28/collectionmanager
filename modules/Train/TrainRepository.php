<?php

namespace modules\Train;

use application\AbstractRepository;
use modules\Train\Transfer\TrainTransferSegment;

class TrainRepository extends AbstractRepository
{
    public function prepareTrainSql(array $columns, array $filter): string {
        $sql = sprintf('SELECT %s, COUNT(id_trainSegment) AS segmente FROM train LEFT JOIN trainSegment zs ON zs.fk_train = z.id_zug', implode(',', $columns));
        if(count($filter) !== 0) {
            $lastFilter = end($filter);
            $sql.=" WHERE ";
            foreach($filter as $filter) {
                $sql.= $filter;
                if($filter !== $lastFilter) {
                    $sql.=' OR ';
                }
            }
        }

        return $sql;
    }

    public function getTrains($sortColumn = 'id_zug', $sortDirection = 'ASC', $searchKeyword = ''): ?array {
        $sql = 'SELECT id_zug, designation, COUNT(id_trainSegment) AS segmente FROM train z LEFT JOIN trainSegment ts ON ts.fk_train = z.id_train GROUP by id_zug';

        if(!$searchKeyword == '') {
            $searchKeyword = strtr($searchKeyword, '+', ' ');
            $sql = $sql . 'WHERE ';
            foreach ($this->getConfig() as $key => $value) {
                if($value['sortable']) {
                    $sql = $sql . $value['sortColumnName'] . ' LIKE "' . $searchKeyword .'" OR ';
                }
            }
            $sql = substr($sql, 0, -4);
        }
        $sql .= ' ORDER BY ' . $sortColumn . ' ' .$sortDirection;

        return $this->getDatabase()->query($sql)->resultSet();
    }

    public function findTrainById($id, $sortColumn = 'id_train', $sortDirection = 'ASC', $searchKeyword = ''): ?array {
        $sql = 'SELECT id_train, fk_scale, designation, ts.id_trainSegment, ts.fk_segmentEntity, ts.position, st.type FROM train z 
                LEFT JOIN trainSegment ts ON ts.fk_train = z.id_train 
                LEFT JOIN segmentType st ON ts.fk_segmentType = st.id_segmentType 
                WHERE id_train = :id_train';

        if(!$searchKeyword == '') {
        $searchKeyword = strtr($searchKeyword, '+', ' ');
            $sql = $sql . 'WHERE ';
            foreach ($this->getConfig() as $key => $value) {
                if($value['sortable']) {
                    $sql = $sql . $value['sortColumnName'] . ' LIKE "' . $searchKeyword .'" OR ';
                }
            }
            $sql = substr($sql, 0, -4);
        }
        $sql .= ' ORDER BY ' . $sortColumn . ' ' .$sortDirection;
        $this->getDatabase()->query($sql);

        $this->getDatabase()->bind(':id_train', $id);

        $row = $this->getDatabase()->resultSet();

        if(empty($row)) {
            $row = null;
        }

        //var_dump($row);

        return $row;
    }

    public function queryTrainSegmentById($id): ?array {
        $sql = 'SELECT * FROM trainSegment WHERE id_trainSegment = :id_trainSegment';

        $this->getDatabase()->query($sql);

        $this->getDatabase()->bind(':id_trainSegment', $id);

        $row = $this->getDatabase()->resultSet();

        if(empty($row)) {
            $row = null;
        }

        //var_dump($row);

        return $row;
    }

    public function insertTrainSegment(TrainTransferSegment $trainSegmentTransfer) {
        $trainSegmentTransfer
            ->requireFkTrain()
            ->requireFkSegmentType()
            ->requireFkSegmentEntity();

        if($trainSegmentTransfer->getPosition() === null) {
            $sqlPosition = 'SELECT MAX(position) as max  FROM trainSegment WHERE fk_train = :fk_train;';
            $this->getDatabase()->query($sqlPosition);
            $this->getDatabase()->bind(':fk_train', $trainSegmentTransfer->getFkTrain());

            $result = $this->getDatabase()->resultSet();
            $trainSegmentTransfer->setPosition($result[0]->max + 1);
        }

        $this->getDatabase()->query('INSERT INTO trainSegment (
            fk_train, fk_segmentType, fk_segmentEntity, position
        ) VALUES (
            :fk_train, :fk_segmentType, :fk_segmentEntity, :position
        )');

        $this->getDatabase()->bind(':fk_train', $trainSegmentTransfer->getFkTrain());
        $this->getDatabase()->bind(':fk_segmentType', $trainSegmentTransfer->getFkSegmentType());
        $this->getDatabase()->bind(':fk_segmentEntity', $trainSegmentTransfer->getFkSegmentEntity());
        $this->getDatabase()->bind(':position', $trainSegmentTransfer->getPosition());

        if ($result = $this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function updateTrainSegment2(TrainTransferSegment $trainSegmentTransfer):bool {
        $trainSegmentTransfer
            ->requireIdTrainSegment()
            ->requireFkSegmentType()
            ->requireFkSegmentEntity();

        $this->getDatabase()->query('UPDATE trainSegment SET 
        fk_segmentType = :fk_segmentType, fk_segmentEntity = :fk_segmentEntity
        WHERE id_trainSegment = :id_trainSegment');

        $this->getDatabase()->bind(':id_trainSegment', $trainSegmentTransfer->getIdTrainSegment());
        $this->getDatabase()->bind(':fk_segmentType', $trainSegmentTransfer->getFkSegmentType());
        $this->getDatabase()->bind(':fk_segmentEntity', $trainSegmentTransfer->getFkSegmentEntity());

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTrainSegment($id, $data):bool {
        $sqlPossition = 'SELECT MAX(position) as max FROM trainSegment;';
        $this->getDatabase()->query($sqlPossition);

        $maxPossition = $this->getDatabase()->resultSet();

        $possition = $maxPossition[0]->max + 1;

        $this->getDatabase()->query('UPDATE trainSegment SET 
        fk_segmentType = :fk_segmentType, fk_segmentEntity = :fk_segmentEntity
        WHERE id_trainSegment = :id_trainSegment');

        $this->getDatabase()->bind(':id_trainSegment', $id);
        var_dump($data);
        $this->getDatabase()->bind(':fk_segmentType', $data['fkSegmentEntity']);
        $this->getDatabase()->bind(':fk_segmentEntity', $data['segmentEntity']);

        if ($this->getDatabase()->execute()) {

            return true;
        } else {
            return false;
        }
    }

    public function deleteTrainSegmentById($id): bool {
        $this->getDatabase()->query('DELETE FROM trainSegment WHERE id_trainSegment = :id_trainSegment');

        $this->getDatabase()->bind(':id_trainSegment', $id);


        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertTrain($data):bool {
        $this->getDatabase()->query('INSERT INTO train (
            fk_scale, designation
        ) VALUES (
            :fk_scale, :designation
        )');

        $this->getDatabase()->bind(':fk_scale', $data['fk_scale']);
        $this->getDatabase()->bind(':designation', $data['designation']);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTrain($id, $data):bool {
        $this->getDatabase()->query('UPDATE train SET
            fk_scale = :fk_scale, designation = :designation
         WHERE id_train = :id_train');

        $this->getDatabase()->bind(':id_train', $id);
        $this->getDatabase()->bind(':fk_scale', $data['fk_scale']);
        $this->getDatabase()->bind(':designation', $data['designation']);

        var_dump($id);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteTrainById($id): bool {
        $this->getDatabase()->query('DELETE FROM train WHERE id_train = :id_train');

        $this->getDatabase()->bind(':id_train', $id);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
