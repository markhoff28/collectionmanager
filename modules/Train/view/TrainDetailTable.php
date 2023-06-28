<?php

namespace modules\Train\view;

use application\AbstractTable;
use application\TableConfig;

class TrainDetailTable extends AbstractTable
{
    private int $trainId;

    public function configure(TableConfig $tableConfig): TableConfig
    {
        $tableConfig->setHeader([
            'position' => 'Position',
            'msDesignation' => 'Maßstab',
            'type' => 'Typ',
            'eDesignation' => 'Epoche',
            'colDesignation' => 'Farbe',
            'name' => 'Bezeichnung',
            'modelseries' => 'Baureihe',
            'manufacturernumber' => 'Herstellernummer',
            'price' => 'Preis',
        ]);

        $tableConfig->setMenu([
            'createAction' => [
                'menuLabel' => 'Anlegen',
                'menuPoint' => 'create',
                'wrapperClass' => 'green',
            ],
        ]);

        $tableConfig->setSortable([
            'position',
            'designation',
            'type',
        ]);

        $tableConfig->setSearchable([
            'beschreibung',
            //'msBezeichnung',
        ]);

        $tableConfig->setTableMenu([
            'detailAction' => [
                'menuLabel' => 'Detail',
                'menuPoint' => 'detail',
                'wrapperClass' => 'blue',
                'targetTable' => 'train',
            ],
            'updateAction' => [
                'menuLabel' => 'Update',
                'menuPoint' => 'update',
                'wrapperClass' => 'orange',
                'targetTable' => 'train',
            ],
            'deleteAction' => [
                'menuLabel' => 'Löschen',
                'menuPoint' => 'delete',
                'wrapperClass' => 'red',
                'targetTable' => 'train',
            ],
        ]);

        return $tableConfig;
    }

    public function prepareSql()
    {
        $columns = array_keys($this->tableConfig->header);

        array_splice($columns, array_search('segmente', $columns));

        $sql = sprintf('SELECT %s, COUNT(id_zugSegment) AS segmente, ms.bezeichnung as msBezeichnung FROM zug z LEFT JOIN zugSegment zs ON zs.fk_train = z.id_zug Left JOIN massstab as ms on z.fk_massstab = ms.id_massstab', 'z.'.implode(', z.', $columns));

        /*$sql = 'SELECT id_zug, fk_massstab, beschreibung,ms.bezeichnung as msBezeichnung, zs.id_zugSegment, zs.fk_endity, zs.possition, zet.type FROM zug z
                Left JOIN massstab as ms on z.fk_massstab = ms.id_massstab            
                LEFT JOIN zugSegment zs ON zs.fk_zug = z.id_zug 
                LEFT JOIN zugEndityType zet ON zs.fk_zugEndityType = zet.id_zugEndityType 
                WHERE id_zug = ' . $this->getTrainId();*/

        return $sql;
    }

    function getTableName()
    {
        return 'train';
    }
/*
    public function getConfig()
    {
        return [
            'position' => [
                'label' => 'Position',
                'columnName' => 'position',
                'sortColumnName' => 'position',
                'type' => 'text',
                'sortable' => true,
            ],
            'massstab' => [
                'label' => 'Maßstab',
                'columnName' => 'msBezeichnung',
                'columnNameFK' => 'fk_massstab',
                'sortColumnName' => 'ms.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'type' => [
                'label' => 'Type',
                'columnName' => 'type',
                'sortColumnName' => 'type',
                'type' => 'text',
                'sortable' => true,
            ],
            'epoche' => [
                'label' => 'Epoche',
                'columnName' => 'eBezeichnung',
                'columnNameFK' => 'fk_epoche',
                'sortColumnName' => 'e.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'farbe' => [
                'label' => 'Farbe',
                'columnName' => 'fBezeichnung',
                'columnNameFK' => 'fk_farbe',
                'sortColumnName' => 'f.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'name' => [
                'label' => 'Bezeichnung',
                'columnName' => 'name',
                'sortColumnName' => 'name',
                'wrapper' => 'h1',
                'type' => 'text',
                'validation' => [
                    'regex' => '',
                    'minlenth' => '3',
                ],
                'sortable' => true,
            ],
            'baureihe' => [
                'label' => 'Baureihe',
                'columnName' => 'baureihe',
                'sortColumnName' => 'baureihe',
                'wrapper' => 'h2',
                'type' => 'text',
                'sortable' => true,
            ],
            'herstellerNR' => [
                'label' => 'Herstellernummer',
                'columnName' => 'herstellerNR',
                'sortColumnName' => 'herstellerNR',
                'wrapper' => 'h2',
                'type' => 'number',
                'sortable' => true,
            ],
            'preis' => [
                'label' => 'Preis',
                'columnName' => 'preis',
                'sortColumnName' => 'preis',
                'wrapper' => 'h2',
                'type' => 'number',
                'sortable' => true,
            ],
        ];
    }*/

    public function setTrainId($trainId) {
        $this->trainId = $trainId;
    }

    private function getTrainId(): int
    {
        return $this->trainId;
    }
}
