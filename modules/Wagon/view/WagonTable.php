<?php

namespace modules\Wagon\view;

use application\AbstractTable;
use application\TableConfig;

class WagonTable extends AbstractTable
{

    function configure(TableConfig $tableConfig): TableConfig
    {
        $tableConfig->setHeader([
            'id_wagon' => 'Id',
            'msDesignation' => 'Maßstab',
            'wtDesignation' => 'Wagontyp',
            'eDesignation' => 'Epoche',
            'colDesignation' => 'Farbe',
            'kDesignation' => 'Kupplungsart',
            'name' => 'Bezeichnung',
            'modelseries' => 'Baureihe',
            'manufacturernumber' => 'Hersteller Nummer',
            'price' => 'Preis',
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
            'id_wagon',
            'msDesignation',
            'wtDesignation',
            'eDesignation',
            'colDesignation',
            'kDesignation',
            'name',
            'modelseries',
            'manufacturernumber',
            'price',
            'numberofaxles',
            'link',
        ]);

        $tableConfig->setSearchable([
            'name',
            'modelseries',
            'manufacturernumber',
            'price',
            'numberofaxles',
            'link',
        ]);

        $tableConfig->setTableMenu([
            'detailAction' => [
                'menuLabel' => 'Detail',
                'menuPoint' => 'detail',
                'wrapperClass' => 'blue',
                'targetTable' => 'wagon',
            ],
            'updateAction' => [
                'menuLabel' => 'Update',
                'menuPoint' => 'update',
                'wrapperClass' => 'orange',
                'targetTable' => 'wagon',
            ],
            'deleteAction' => [
                'menuLabel' => 'Löschen',
                'menuPoint' => 'delete',
                'wrapperClass' => 'red',
                'targetTable' => 'wagon',
            ],
        ]);

        return $tableConfig;
    }

    function prepareSql()
    {
        $columns = array_keys($this->tableConfig->header);

        array_splice($columns, array_search('segmente', $columns));

        //$sql = sprintf('SELECT %s, COUNT(id_zugSegment) AS segmente FROM zug z LEFT JOIN zugSegment zs ON zs.fk_zug = z.id_zug ', 'z.'.implode(', z.', $columns));
        $sql = 'SELECT id_wagon, fk_scale, fk_epoch, fk_colour, fk_couplingtype, fk_wagonType, name, modelseries, manufacturernumber, price, numberofaxles, link, ms.designation as msDesignation, e.designation as eDesignation, col.designation as colDesignation, k.designation as kDesignation, wt.designation as wtDesignation
            FROM wagon as w
                INNER JOIN scale as ms on w.fk_scale = ms.id_scale
                INNER JOIN epoch as e on w.fk_epoch = e.id_epoch
                INNER JOIN colour as col on w.fk_colour = col.id_colour
                INNER JOIN couplingtype as k on w.fk_couplingtype = k.id_couplingtype
                INNER JOIN wagonType as wt on w.fk_wagonType = wt.id_wagontype';
        return $sql;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'wagon';
    }
}
