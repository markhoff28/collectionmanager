<?php

namespace application;

class BundleLocator
{
    private $bundleDependencies = [];

    public function set(
        string $dependency, string $className
    ) {
        $this->bundleDependencies[$dependency] = $className;
    }

    /**
     * @param $dependency
     * @param array|null $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($dependency, array $arguments = null) {
        if(!array_key_exists($dependency, $this->bundleDependencies)) {
            throw new \Exception(sprintf('Bundle Dependency not found: %s', $dependency));
        }

        return new $this->bundleDependencies[$dependency];
    }
}
