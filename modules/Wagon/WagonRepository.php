<?php

namespace modules\Wagon;

use application\AbstractRepository;

class WagonRepository extends AbstractRepository
{
    public function queryAllWagons($sortColumn = 'id_wagon', $sortDirection = 'ASC', $searchKeyword = '') {
        $sql = '
            SELECT id_wagon, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_wagonType, name, modelseries, manufacturernumber, price, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, wt.designation as wtDesignation
            FROM wagon as w
                INNER JOIN scale as ms on w.fk_scale = ms.id_scale
                INNER JOIN epoch as e on w.fk_epoch = e.id_epoch
                INNER JOIN colour as col on w.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on w.fk_couplingtype = k.id_couplingtype
                INNER JOIN wagonType as wt on w.fk_wagonType = wt.id_wagontype
        ';
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

        $results = $this->getDatabase()->resultSet();

        return $results;
    }

    public function queryWagonByID($id) {
        $sql = '
            SELECT id_wagon, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_wagonType, name, modelseries, manufacturernumber, price, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, wt.designation as wtDesignation
            FROM wagon as w
                INNER JOIN scale as ms on w.fk_scale = ms.id_scale
                INNER JOIN epoch as e on w.fk_epoch = e.id_epoch
                INNER JOIN colour as col on w.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on w.fk_couplingtype = k.id_couplingtype
                INNER JOIN wagonType as wt on w.fk_wagonType = wt.id_wagontype
            WHERE id_wagon = :id_wagon; 
        ';
        $this->getDatabase()->query($sql);

        $this->getDatabase()->bind(':id_wagon', $id);

        $row = $this->getDatabase()->resultSet();

        if(empty($row)) {
            $row = null;
        }

        return $row;
    }

    public function insertWagon($data) {
        $this->getDatabase()->query('INSERT INTO wagon (
            fk_scale, fk_wagonType, fk_epoch, fk_colour, fk_couplingtype, name, modelseries, manufacturernumber, price, numberofaxles, link
        ) VALUES (
            :fk_scale, :fk_wagonType, :fk_epoch, :fk_colour,  :fk_couplingtype, :name, :modelseries, :manufacturernumber, :price, :numberofaxles, :link
        )');

        $this->getDatabase()->bind(':fk_scale', $data['fk_scale']);
        $this->getDatabase()->bind(':fk_wagonType', $data['fk_wagonType']);
        $this->getDatabase()->bind(':fk_epoch', $data['fk_epoch']);
        $this->getDatabase()->bind(':fk_colour', $data['fk_colour']);
        $this->getDatabase()->bind(':fk_couplingtype', $data['fk_couplingtype']);
        $this->getDatabase()->bind(':name', $data['name']);
        $this->getDatabase()->bind(':modelseries', $data['modelseries']);
        $this->getDatabase()->bind(':manufacturernumber', $data['manufacturernumber']);
        $this->getDatabase()->bind(':price', $data['price']);
        $this->getDatabase()->bind(':numberofaxles', $data['numberofaxles']);
        $this->getDatabase()->bind(':link', $data['link']);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateWagon($id, $data) {
        $this->getDatabase()->query('UPDATE wagon SET 
        fk_scale = :fk_scale, fk_wagonType = :fk_wagonType, fk_epoch = :fk_epoch, fk_colour = :fk_colour, fk_couplingtype = :fk_couplingtype,
        name = :name, modelseries = :modelseries, manufacturernumber = :manufacturernumber, price = :price, numberofaxles = :numberofaxles, link = :link
        WHERE id_wagon = :id_wagon');

        $this->getDatabase()->bind(':id_wagon', $id);
        $this->getDatabase()->bind(':fk_scale', $data['fk_scale']);
        $this->getDatabase()->bind(':fk_wagonType', $data['fk_wagonType']);
        $this->getDatabase()->bind(':fk_epoch', $data['fk_epoch']);
        $this->getDatabase()->bind(':fk_colour', $data['fk_colour']);
        $this->getDatabase()->bind(':fk_couplingtype', $data['fk_couplingtype']);
        $this->getDatabase()->bind(':name', $data['name']);
        $this->getDatabase()->bind(':modelseries', $data['modelseries']);
        $this->getDatabase()->bind(':manufacturernumber', $data['manufacturernumber']);
        $this->getDatabase()->bind(':price', $data['price']);
        $this->getDatabase()->bind(':numberofaxles', $data['numberofaxles']);
        $this->getDatabase()->bind(':link', $data['link']);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteWagonById($id) {
        $this->getDatabase()->query('DELETE FROM wagon WHERE id_wagon = :id_wagon');

        $this->getDatabase()->bind(':id_wagon', $id);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function  getAttributesValues($attribute) {
        $sql = sprintf('
            SELECT id_%s, designation
            FROM %s; 
        ', $attribute, $attribute);

        $this->getDatabase()->query($sql);
        $results = $this->getDatabase()->resultSet();

        return $results;
    }
}
