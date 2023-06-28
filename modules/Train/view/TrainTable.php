<?php

namespace modules\Train\view;

use application\AbstractController;
use application\AbstractRepository;
use application\AbstractTable;
use application\TableConfig;

class TrainTable extends AbstractTable
{
    /**
     * @param TableConfig $tableConfig
     * @return TableConfig
     */
    public function configure(TableConfig $tableConfig): TableConfig
    {
        $tableConfig->setHeader([
            'id_train' => 'ZugId',
            'designation' => 'Zugbezeichnung',
            'segments' => 'Zuglänge',
            'msDesignation' => 'Maßstab',
        ]);

        $tableConfig->setMenu([
            'createAction' => [
                'menuLabel' => 'Anlegen',
                'menuPoint' => 'create',
                'wrapperClass' => 'green',
            ],
        ]);

        $tableConfig->setSortable([
            'id_train',
            'designation',
            'segments',
            'msDesignation',
        ]);

        $tableConfig->setSearchable([
            'designation',
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

    public function prepareSql(): string {
        $columns = array_keys($this->tableConfig->header);

        array_splice($columns, array_search('segments', $columns));

        $sql = sprintf('SELECT %s, COUNT(id_trainSegment) AS segments, ms.designation as msDesignation FROM train tr LEFT JOIN trainSegment ts ON ts.fk_train = tr.id_train Left JOIN scale as ms on tr.fk_scale = ms.id_scale', 'tr.'.implode(', tr.', $columns));

        return $sql;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'train';
    }

}
