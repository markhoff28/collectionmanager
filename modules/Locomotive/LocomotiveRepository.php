<?php

namespace modules\Locomotive;

use application\AbstractRepository;

class LocomotiveRepository extends AbstractRepository
{
    public function queryAllLocomotives($sortColumn = 'id_locomotive', $sortDirection = 'ASC', $searchKeyword = ''): ?array {

        $sql = '
            SELECT id_locomotive, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_locomotiveType, fk_series, name, modelseries, manufacturernumber, price, digital, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, lk.designation as lkDesignation, s.designation as sDesignation
            FROM locomotive as l
                INNER JOIN scale as ms on l.fk_scale = ms.id_scale
                INNER JOIN epoch as e on l.fk_epoch = e.id_epoch
                INNER JOIN colour as col on l.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on l.fk_couplingtype = k.id_couplingtype
                INNER JOIN locomotiveType as lk on l.fk_locomotiveType = lk.id_locomotiveType
                INNER JOIN series as s on l.fk_series = s.id_series
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

    public function queryLocomotiveByID($id): ?array {
        $sql = '
            SELECT id_locomotive, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_locomotiveType, fk_series, name, modelseries, manufacturernumber, price, digital, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, lk.designation as lkDesignation, s.designation as sDesignation
            FROM locomotive as l
                INNER JOIN scale as ms on l.fk_scale = ms.id_scale
                INNER JOIN epoch as e on l.fk_epoch = e.id_epoch
                INNER JOIN colour as col on l.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on l.fk_couplingtype = k.id_couplingtype
                INNER JOIN locomotiveType as lk on l.fk_locomotiveType = lk.id_locomotiveType
                INNER JOIN series as s on l.fk_series = s.id_series
            WHERE id_locomotive = :id_locomotive; 
        ';

        $this->getDatabase()->query($sql);

        $this->getDatabase()->bind(':id_locomotive', $id);

        $row = $this->getDatabase()->resultSet();

        if(empty($row)) {
            $row = null;
        }

        return $row;
    }

    public function insertLocomotive($data): bool {
        $this->getDatabase()->query('INSERT INTO locomotive (
            fk_scale, fk_locomotiveType, fk_epoch, fk_colour, fk_series, fk_couplingtype, name, modelseries, manufacturernumber, price, digital, numberofaxles, link
        ) VALUES (
            :fk_scale, :fk_locomotiveType, :fk_epoch, :fk_colour, :fk_series, :fk_couplingtype, :name, :modelseries, :manufacturernumber, :price, :digital, :numberofaxles, :link
        )');
        var_dump($data);

        $this->getDatabase()->bind(':fk_scale', $data['msDesignation']);
        $this->getDatabase()->bind(':fk_locomotiveType', $data['lkDesignation']);
        $this->getDatabase()->bind(':fk_epoch', $data['eDesignation']);
        $this->getDatabase()->bind(':fk_colour', $data['colDesignation']);
        $this->getDatabase()->bind(':fk_series', $data['sDesignation']);
        $this->getDatabase()->bind(':fk_couplingtype', $data['kDesignation']);
        $this->getDatabase()->bind(':name', $data['name']);
        $this->getDatabase()->bind(':modelseries', $data['modelseries']);
        $this->getDatabase()->bind(':manufacturernumber', $data['manufacturernumber']);
        $this->getDatabase()->bind(':price', $data['price']);
        $this->getDatabase()->bind(':digital', $data['digital']);
        $this->getDatabase()->bind(':numberofaxles', $data['numberofaxles']);
        $this->getDatabase()->bind(':link', $data['link']);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateLocomotive($id, $data): bool {
        $this->getDatabase()->query('UPDATE locomotive SET 
        fk_scale = :fk_scale, fk_locomotiveType = :fk_locomotiveType, fk_epoch = :fk_epoch, fk_colour = :fk_colour, fk_series = :fk_series, fk_couplingtype = :fk_couplingtype,
        name = :name, modelseries = :modelseries, manufacturernumber = :manufacturernumber, price = :price, digital = :digital, numberofaxles = :numberofaxles, link = :link
        WHERE id_locomotive = :id_locomotive');

        $this->getDatabase()->bind(':id_locomotive', $id);
        $this->getDatabase()->bind(':fk_scale', $data['msDesignation']);
        $this->getDatabase()->bind(':fk_locomotiveType', $data['lkDesignation']);
        $this->getDatabase()->bind(':fk_epoch', $data['eDesignation']);
        $this->getDatabase()->bind(':fk_colour', $data['colDesignation']);
        $this->getDatabase()->bind(':fk_series', $data['sDesignation']);
        $this->getDatabase()->bind(':fk_couplingtype', $data['kDesignation']);
        $this->getDatabase()->bind(':name', $data['name']);
        $this->getDatabase()->bind(':modelseries', $data['modelseries']);
        $this->getDatabase()->bind(':manufacturernumber', $data['manufacturernumber']);
        $this->getDatabase()->bind(':price', $data['price']);
        $this->getDatabase()->bind(':digital', $data['digital']);
        $this->getDatabase()->bind(':numberofaxles', $data['numberofaxles']);
        $this->getDatabase()->bind(':link', $data['link']);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteLocomotiveById($id): bool {
        $this->getDatabase()->query('DELETE FROM locomotive WHERE id_locomotive = :id_locomotive');

        $this->getDatabase()->bind(':id_locomotive', $id);

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
