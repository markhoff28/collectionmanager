<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("application/Autoloader.php");

$application = new \application\Application();

try {
    $application->start();
} catch(Exception $exception) {
    echo $exception->getMessage();
}