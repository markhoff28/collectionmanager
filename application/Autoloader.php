<?php

namespace application;

class Autoloader {

    /**
     * @param $className
     *
     * @return bool
     */
    static public function loader($className):bool {

        $filename = str_replace("\\", '/', $className) . ".php";

        if (file_exists($filename)) {

            require_once($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
spl_autoload_register('application\Autoloader::loader');
