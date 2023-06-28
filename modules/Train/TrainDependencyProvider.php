<?php

namespace modules\Train;

use application\AbstractDependencyProvider;
use application\Container;
use modules\Locomotive\LocomotiveFacade;
use modules\Stock\Plugin\StockPluginPostSafeLocomotive;
use modules\Stock\Plugin\StockPluginPostSafeWagon;
use modules\Stock\StockFacade;
use modules\Wagon\WagonFacade;

class TrainDependencyProvider extends AbstractDependencyProvider
{
    public const FACADE_LOCOMOTIVE = 'FACADE_LOCOMOTIVE';
    public const FACADE_STOCK = 'FACADE_STOCK';
    public const FACADE_WAGON = 'FACADE_WAGON';
    public const PLUGINS_POST_SAVE = 'PLUGINS_POST_SAVE';

    function provideDependencies(Container $container): Container
    {
        //var_dump($container);
        $container = $this->addLocomotiveFacade($container);
        $container = $this->addStockFacade($container);
        $container = $this->addWagonFacade($container);
        $container = $this->addPostSavePlugins($container);

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

    public function addStockFacade(Container $container): Container {
        $container->set(
            self::FACADE_STOCK,
            function (Container $container): StockFacade {
                return $container->getLocator()->stock()->facade();
            }
        );

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

    private function addPostSavePlugins(Container $container): Container {
        $container->set(
            self::PLUGINS_POST_SAVE,
            function(): array {
                return $this->providePostSavePlugins();
            }
        );

        return $container;
    }

    private function providePostSavePlugins(): array {
        return [
            new StockPluginPostSafeLocomotive(),
            new StockPluginPostSafeWagon()
        ];
    }
}
