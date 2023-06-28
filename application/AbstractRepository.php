<?php

namespace application;

class AbstractRepository
{
    private static $connection;

    public function getDatabase() {
        if(!is_object(self::$connection)) {
            self::$connection = new Database();
        }

        return self::$connection;
    }

    public function getAttributesValues($attribute) {
        $sql = sprintf('
            SELECT id_%s, designation
            FROM %s; 
        ', $attribute, $attribute);

        $this->getDatabase()->query($sql);
        $results = $this->getDatabase()->resultSet();

        return $results;
    }

    public function getConfig() {
        $moduleName = $this->getModule();
        $configFile = sprintf('modules\%s\%sConfig',$moduleName, $moduleName);
        $config = new $configFile;
        if(is_callable([$config, 'getConfig'])) {
            return $config->getConfig();
        }
        throw new \Exception('Config not found');
    }
    private function getModule() {
        return explode('\\', get_called_class()) [1];
    }
}
