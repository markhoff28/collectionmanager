<?php

namespace modules\Locomotive;

class LocomotiveConfig
{
    public function getConfig()
    {
        return [
            'id_Locomotive' => [
                'label' => 'ID',
                'columnName' => 'id_locomotive',
                'wrapper' => 'p',
                'sortable' => false,
            ],
            'scale' => [
                'label' => 'Maßstab',
                'columnName' => 'msDesignation',
                'columnNameFK' => 'fk_scale',
                'sortColumnName' => 'ms.designation',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'locomotiveType' => [
                'label' => 'Lokomotivtype',
                'columnName' => 'lkDesignation',
                'columnNameFK' => 'fk_locomotiveType',
                'sortColumnName' => 'lk.designation',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'epoch' => [
                'label' => 'Epoche',
                'columnName' => 'eDesignation',
                'columnNameFK' => 'fk_epoch',
                'sortColumnName' => 'e.designation',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'colour' => [
                'label' => 'Farbe',
                'columnName' => 'colDesignation',
                'columnNameFK' => 'fk_colour',
                'sortColumnName' => 'f.designation',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'series' => [
                'label' => 'Serie',
                'columnName' => 'sDesignation',
                'columnNameFK' => 'fk_series',
                'sortColumnName' => 's.designation',
                'type' => 'select',
                'sortable' => true,
            ],
            'couplingtype' => [
                'label' => 'Kupplungsart',
                'columnName' => 'kDesignation',
                'columnNameFK' => 'fk_couplingtype',
                'sortColumnName' => 'k.designation',
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
            'modelseries' => [
                'label' => 'Baureihe',
                'columnName' => 'modelseries',
                'sortColumnName' => 'baureihe',
                'wrapper' => 'h2',
                'type' => 'text',
                'sortable' => true,
            ],
            'manufacturernumber' => [
                'label' => 'Herstellernummer',
                'columnName' => 'manufacturernumber',
                'sortColumnName' => 'herstellerNR',
                'wrapper' => 'h2',
                'type' => 'number',
                'sortable' => true,
            ],
            'price' => [
                'label' => 'Preis',
                'columnName' => 'price',
                'sortColumnName' => 'price',
                'wrapper' => 'h2',
                'type' => 'number',
                'sortable' => true,
            ],
            'digital' => [
                'label' => 'Digital',
                'columnName' => 'digital',
                'type' => 'number',
                'sortable' => false,
            ],
            'numberofaxles' => [
                'label' => 'Achsanzahl',
                'columnName' => 'numberofaxles',
                'type' => 'number',
                'wrapper' => 'h3',
                'sortable' => false,
            ],
            'link' => [
                'label' => 'Link zum Hersteller',
                'columnName' => 'link',
                'sortColumnName' => 'link',
                'wrapper' => 'h3',
                'type' => 'text',
                'sortable' => true,
            ],
        ];
    }
}
