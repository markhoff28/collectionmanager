<?php

namespace modules\Locomotive\view;

use application\AbstractTable;
use application\TableConfig;

class LocomotiveTable extends AbstractTable
{
    function configure(TableConfig $tableConfig): TableConfig
    {
        $tableConfig->setHeader([
            'id_locomotive' => 'ID',
            'msDesignation' => 'Maßstab',
            'lkDesignation' => 'Lokomotivtyp',
            'eDesignation' => 'Epoche',
            'colDesignation' => 'Farbe',
            'sDesignation' => 'Serie',
            'kDesignation' => 'Kupplungsart',
            'name' => 'Bezeichnung',
            'modelseries' => 'Baureihe',
            'manufacturernumber' => 'Hersteller Nummer',
            'price' => 'Preis',
            'digital' => 'Digital',
            'numberofaxles' => 'Achsanzahl',
            'link' => 'Link',
        ]);

        $tableConfig->setMenu([
            'createAction' => [
                'menuLabel' => 'Anlegen',
                'menuPoint' => 'create',
                'wrapperClass' => 'green',
            ],
        ]);

        $tableConfig->setSortable([
            'id_locomotive',
            'msDesignation',
            'lkDesignation',
            'eDesignationg',
            'colDesignation',
            'kDesignation',
            'name',
            'modelseries',
            'manufacturernumber',
            'price',
            'digital',
            'numberofaxles',
            'link',
        ]);

        $tableConfig->setSearchable([
            'id_locomotive',
            'name',
            'modelseries',
            'manufacturernumber',
            'price',
            'digital',
            'numberofaxles',
            'link',
        ]);

        $tableConfig->setTableMenu([
            'detailAction' => [
                'menuLabel' => 'Detail',
                'menuPoint' => 'detail',
                'wrapperClass' => 'blue',
                'targetTable' => 'locomotive',
            ],
            'updateAction' => [
                'menuLabel' => 'Update',
                'menuPoint' => 'update',
                'wrapperClass' => 'orange',
                'targetTable' => 'locomotive',
            ],
            'deleteAction' => [
                'menuLabel' => 'Löschen',
                'menuPoint' => 'delete',
                'wrapperClass' => 'red',
                'targetTable' => 'locomotive',
            ],
        ]);

        return $tableConfig;
    }
    function prepareSql()
    {
        $columns = array_keys($this->tableConfig->header);

        array_splice($columns, array_search('segmente', $columns));

        //$sql = sprintf('SELECT %s, COUNT(id_zugSegment) AS segmente FROM zug z LEFT JOIN zugSegment zs ON zs.fk_zug = z.id_zug ', 'z.'.implode(', z.', $columns));
        $sql = 'SELECT id_locomotive, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_locomotiveType, fk_series, name, modelseries, manufacturernumber, price, digital, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, lk.designation as lkDesignation, s.designation as sDesignation
            FROM locomotive as l
                INNER JOIN scale as ms on l.fk_scale = ms.id_scale
                INNER JOIN epoch as e on l.fk_epoch = e.id_epoch
                INNER JOIN colour as col on l.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on l.fk_couplingtype = k.id_couplingtype
                INNER JOIN locomotiveType as lk on l.fk_locomotiveType = lk.id_locomotiveType
                INNER JOIN series as s on l.fk_series = s.id_series';
        return $sql;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'locomotive';
    }


}
