<?php

namespace application;

class Container
{
    private ?Locator $locator = null;
    private array $dependencies = [];

    /**
     * @param string $key
     * @param callable $value
     * @return void
     */
    public function set(string $key, callable $value): void {
        if(array_key_exists($key, $this->dependencies)) {
            throw new \Exception('Dependency already included');
        }

        $this->dependencies[$key] = $value;
    }

    /**
     * @param $key
     * @return callable
     */
    public function get($key): callable {
        if(!isset($this->dependencies[$key])) {
            throw new \Exception('Dependency not included');
        }

        return $this->dependencies[$key];
    }

    /**
     * @return Locator
     */
    public function getLocator(): Locator {
        if($this->locator === null) {
            $this->locator = new Locator();
        }

        return $this->locator;
    }
}
