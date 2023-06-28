<?php

namespace modules\Locomotive;

use application\AbstractDependencyProvider;
use application\Container;
use modules\Stock\Plugin\StockPluginLocomotive;
use modules\Wagon\WagonFacade;

class LocomotiveDependencyProvider extends AbstractDependencyProvider
{
    public const FACADE_WAGON = 'FACADE_WAGON';
    public const PLUGINS_DETAILS = 'PLUGINS_DETAILS';

    public function provideDependencies(Container $container): Container
    {
        $container = $this->addWagonFacade($container);
        $container = $this->addDetailPlugins($container);

        return $container;
    }

    public function addWagonFacade(Container $container): Container {
        $container->set(
            self::FACADE_WAGON,
            function (Container $container): WagonFacade {
                return $container->getLocator()->wagon()->facade();
            }
        );

        return $container;
    }

    public function addDetailPlugins(Container $container): Container {
        $container->set(
            self::PLUGINS_DETAILS,
            function (): array {
                return $this->provideDetailPlugins();
            }
        );

        return $container;
    }

    private function provideDetailPlugins(): array {
        return [
            new StockPluginLocomotive(),
        ];
    }
}
