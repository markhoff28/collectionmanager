<?php

namespace modules\Train;

class TrainConfig
{
    public function getConfig()
    {
        return [
            'id_train' => [
                'label' => 'ID',
                'columnName' => 'id_train',
                'sortable' => false,
            ],
            'scale' => [
                'label' => 'Maßstab',
                'columnName' => 'msDesignation',
                'columnNameFK' => 'fk_scale',
                'sortColumnName' => 'ms.designation',
                'type' => 'select',
            ],
            'designation' => [
                'label' => 'Bezeichnung',
                'columnName' => 'designation',
                'sortColumnName' => 'designation',
                'type' => 'text',
            ],
        ];
    }

    /*
     * array(2) {
     * [0]=> object(stdClass)#11 (6) {
     *      ["id_zug"]=> string(1) "1"
     *      ["beschreibung"]=> string(21) "Unser erster Test Zug"
     *      ["id_zugSegment"]=> string(1) "1"
     *      ["fk_endity"]=> string(1) "2"
     *      ["possition"]=> string(1) "0"
     *      ["type"]=> string(10) "lokomotive"
     *  }*/
}
