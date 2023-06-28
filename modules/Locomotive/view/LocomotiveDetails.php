<?php

namespace modules\Locomotive\view;

use application\AbstractDetails;

class LocomotiveDetails extends AbstractDetails
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
