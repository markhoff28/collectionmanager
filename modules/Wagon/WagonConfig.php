<?php

namespace modules\Wagon;

class WagonConfig
{
    public function getConfig()
    {
        return [
            'id_wagon' => [
                'label' => 'ID',
                'columnName' => 'id_wagon',
                'sortable' => false,
            ],
            'scale' => [
                'label' => 'Maßstab',
                'columnName' => 'msDesignation',
                'columnNameFK' => 'fk_scale',
                'sortColumnName' => 'ms.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'wagonType' => [
                'label' => 'Wagontyp',
                'columnName' => 'wtDesignation',
                'columnNameFK' => 'fk_wagonType',
                'sortColumnName' => 'wt.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'epoch' => [
                'label' => 'Epoche',
                'columnName' => 'eDesignation',
                'columnNameFK' => 'fk_epoch',
                'sortColumnName' => 'e.bezeichnung',
                'wrapper' => 'h3',
                'type' => 'select',
                'sortable' => true,
            ],
            'colour' => [
                'label' => 'Farbe',
                'columnName' => 'colDesignation',
                'columnNameFK' => 'fk_colour',
                'sortColumnName' => 'f.bezeichnung',
                'type' => 'select',
                'sortable' => true,
            ],
            'couplingtype' => [
                'label' => 'Kupplungsart',
                'columnName' => 'kDesignation',
                'columnNameFK' => 'fk_couplingtype',
                'sortColumnName' => 'k.bezeichnung',
                'type' => 'select',
                'sortable' => true,
            ],
            'name' => [
                'label' => 'Bezeichnung',
                'columnName' => 'name',
                'sortColumnName' => 'name',
                'wrapper' => 'h1',
                'type' => 'text',
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
                'sortColumnName' => 'preis',
                'wrapper' => 'h2',
                'type' => 'number',
                'sortable' => true,
            ],
            'numberofaxles' => [
                'label' => 'Achsanzahl',
                'columnName' => 'numberofaxles',
                'type' => 'number',
                'sortable' => false,
            ],
            'link' => [
                'label' => 'Link zum Hersteller',
                'columnName' => 'link',
                'sortColumnName' => 'link',
                'type' => 'text',
                'sortable' => true,
            ],
        ];
    }
}
