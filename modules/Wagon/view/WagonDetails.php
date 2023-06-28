<?php

namespace modules\Wagon\view;

use application\AbstractDetails;

class WagonDetails extends AbstractDetails
{

    private array $plugins;

    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;
    }

    public function getPlugins():array
    {
        return $this->plugins;
    }
}
