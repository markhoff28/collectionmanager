<?php

namespace application;

abstract class AbstractDependencyProvider
{
    /**
     * @param Container $container
     * @return Container
     */
    abstract function provideDependencies(Container $container): Container;
}
