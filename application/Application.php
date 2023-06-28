<?php

namespace application;

use application\Traits\URLGeneratorTrait;

class Application
{
    use URLGeneratorTrait;

    public function start() {
        $controller = $this->locateController();
        $action = $this->getAction();
        $params = $this->getQueryParams();
        /**  @var AbstractController $controller */
        if(is_callable([$controller, $action])) {

            $controller->view->setView($this->parseCurrentURL()[1] ?? 'index');
            $controller->view->bindParam('title', $this->getAction());
            $controller->view->bindParam('content', $controller->$action(...$params));
            $controller->view->render();
            return;
        }

        $this->handle404();
    }

    private function locateController() {
        $moduleName = $this->parseCurrentURL()[0];
        if (empty($moduleName)) {
            //$moduleName = 'Locomotive';
        }
        if(!is_dir('modules/'.$moduleName)) {
            throw new \Exception('Controller not found');
        }
        $path = sprintf('modules/%s/%sController.php',$moduleName, $moduleName);

        if(file_exists($path)) {
            $class = sprintf('modules\%s\%sController',$moduleName, $moduleName);
            return new $class;
        }
    }

    public function getQueryParams() {
        $queryParams = explode('/', $_REQUEST['url'] ?? '');
        if(count($queryParams) > 3) {
            return [];
        }
        return array_slice($queryParams, 2, count($queryParams));
    }

    private function getAction() {
        return ($this->parseCurrentURL()[1] ?? 'index').'Action';
    }

    private function parseCurrentURL() {
        return explode('/', $_REQUEST['url'] ?? '');
    }

    /**
     * @return void
     */
    private function handle404() {
        header("HTTP/1.0 404 Not Found");
        $defaultController = new AbstractController();
        $defaultController->pageNotFound();
        $defaultController->view->render();
    }

    private function handleAccessDenied() {

    }
}
