<?php

namespace application;

class Template
{
    private $params = [];
    private $currentModuleName;
    private $currentAction;
    private $defaultFolder;
    private bool $printHeaderAndFooter;

    function __construct($currentModuleName, $currentAction, $printHeaderAndFooter = true) {
        $this->currentModuleName = $currentModuleName;
        $this->currentAction = $currentAction;
        $this->printHeaderAndFooter = $printHeaderAndFooter;
        if ($this->printHeaderAndFooter) {
            $this->printHeader();
            $this->printNavigation();
        }
    }

    function __destruct() {
        if ($this->printHeaderAndFooter) {
            $this->printFooter();
        }
    }

    public function bindParam($name, $value) {
        $this->params[$name] = $value;
    }

    public function setView($currentAction) {
        $this->currentAction = $currentAction;
    }

    public function render() {
        try {
            $fileName = sprintf('modules/%s/view/%s.php', $this->currentModuleName, $this->currentAction);
            if(is_file($fileName)) {
                foreach ($this->params as $param => $paramValue) {
                    $$param = $paramValue;
                }
                require_once ($fileName);
                return;
            }
            $this->defaultFolder = sprintf('views/%s.php', $this->currentAction);
            if(is_file($this->defaultFolder)) {
                foreach ($this->params as $param => $paramValue) {
                    $$param = $paramValue;
                }
                require_once ($this->defaultFolder);
                return;
            }
            throw new \Exception(sprintf('No Template for Action %s fond', $this->currentAction));
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    private function printHeader() {
        require(getcwd() . "/views/head.php");
    }

    private  function  printNavigation() {
        require(getcwd() . "/views/navigation.php");
    }

    private function printFooter() {
        require(getcwd() . "/views/footer.php");
    }
}
