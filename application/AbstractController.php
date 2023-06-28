<?php

namespace application;

use application\Traits\URLGeneratorTrait;
use views\SearchForm;

class AbstractController
{
    use URLGeneratorTrait;

    public $view;

    function __construct() {
        $this->view = new Template($this->getModule(), $this->getAction());
    }

    public function getFactory() {
        $moduleName = $this->getModule();
        $factory = sprintf('modules\%s\%sFactory',$moduleName, $moduleName);
        return new $factory;
    }

    public function getFacade() {
        $moduleName = $this->getModule();
        $facade = sprintf('modules\%s\%sFacade',$moduleName, $moduleName);
        return new $facade;
    }

    public function getReader() {
        $moduleName = $this->getModule();
        $facade = sprintf('modules\%s\Reader\%sReader',$moduleName, $moduleName);
        return new $facade;
    }

    public function getQueryParams() {
        $queryParams = explode('/', $_REQUEST['url'] ?? '');
        if(count($queryParams) > 3) {
            return [];
        }
        return array_slice($queryParams, 2, count($queryParams));
    }

    public function searchForm() {
        $this->SearchForm->createSearchForm();
    }

    public function pageNotFound() {
        $this->view->setView('404');
        return 'Page not found!';
    }

    private function getModule() {
        $moduleName = explode('\\', get_called_class()) [1];
        return $moduleName;
    }

    private function getAction() {
        return ($this->parseCurrentURL()[1] ?? 'index');
    }

    private function parseCurrentURL() {
        return explode('/', $_REQUEST['url'] ?? '');
    }
}
