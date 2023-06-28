<?php

namespace modules\Wagon;

use application\AbstractDependencyProvider;
use application\Container;
use modules\Locomotive\LocomotiveFacade;
use modules\Stock\Plugin\StockPluginLocomotive;

class WagonDependencyProvider extends AbstractDependencyProvider
{
    public const FACADE_LOCOMOTIVE = 'FACADE_LOCOMOTIVE';
    public const PLUGINS_DETAILS = 'PLUGINS_DETAILS';

    function provideDependencies(Container $container): Container
    {
        $container = $this->addLocomotiveFacade($container);
        $container = $this->addDetailPlugins($container);

        return $container;
    }

    public function addLocomotiveFacade(Container $container): Container {
        $container->set(
            self::FACADE_LOCOMOTIVE,
            function (Container $container): LocomotiveFacade {
                return $container->getLocator()->locomotive()->facade();
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
        return [new StockPluginLocomotive()];
    }
}
