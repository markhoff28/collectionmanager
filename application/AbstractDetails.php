<?php

namespace application;

abstract class AbstractDetails extends AbstractView
{
    public function createDetailsAttribute():array {
        $detailsAttribute = [];
        foreach ($this->getConfig() as $key => $config) {
            if(!$config['columnName']) {
                continue;
            }
            $detailsAttribute[$config['columnName']] = $config['label'];
        }
        return $detailsAttribute;
    }
}
