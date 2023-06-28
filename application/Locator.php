<?php

namespace application;

use stdClass;

class Locator
{
    private ?BundleLocator  $bundleLocator = null;

    private array $dependencys = ['Client', 'Facade'];

    public function __call($bundle, array $arguments = null) {
        $bundle = ucfirst($bundle);

        $this->getBundleAssets($bundle);

        return $this->bundleLocator;
    }

    private function getBundleAssets(string $bundleName): void {
        // ToDo never nester
        if(is_null($this->bundleLocator)) {
            $this->bundleLocator = new BundleLocator();
        }

        $bundleClasses = scandir(sprintf('modules/%s/',$bundleName));
        foreach($bundleClasses as $class) {
            foreach ($this->dependencys as $dependency) {
                $className = explode('.', $class)[0];

                if(strpos($class, $dependency)) {
                    $this->bundleLocator->set(
                        strtolower($dependency),
                        sprintf('modules\%s\%s', $bundleName, $className)
                    );
                }
            }
        }
    }
}
