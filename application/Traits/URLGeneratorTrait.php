<?php

namespace application\Traits;

trait URLGeneratorTrait
{
    public function createUrl(
        $parameterSeed = [],
        $action = null,
        $controller = null
    ) {
        if($controller === null) {
            $controller = $this->getCurrentController();
        }

        if($action === null) {
            $action = $this->getCurrentAction();
        }

        $params = array_merge($this->getAssocQueryParams(), $parameterSeed);

        $currentParam = [];
        foreach ($params as $paramKey => $paramValue) {
            $currentParam[] = $paramKey.'='. $paramValue;
        }

        if(count($currentParam) === 0) {
            return sprintf('/mvcSammlungsverwaltung/%s/%s/', $controller, $action);
        }

        return sprintf('/mvcSammlungsverwaltung/%s/%s/?%s', $controller, $action, implode('&', $currentParam));
    }

// TODO: Parameter entfernen sobald er leer wird
    public function generateURL(
        $parameterSeed = [],
        $ignoreQueryParams = false
    ) {
        $currentURL = $_REQUEST['url'];
        $currentParam = [];

        $queryParams = [];
        if(!$ignoreQueryParams) {
            $queryParams = $this->getAssocQueryParams();
        }

        $params = array_merge($queryParams, $parameterSeed);

        foreach ($params as $paramKey => $paramValue) {
            $currentParam[] = $paramKey.'='. $paramValue;
        }
        return '/mvcSammlungsverwaltung/' . $currentURL.'?' .implode('&', $currentParam);
    }

    public function getAssocQueryParams() {
        $assocQueryParams = [];
        $queryParams = explode('&', $_SERVER['QUERY_STRING'] ?? '');
        array_shift($queryParams);
        foreach ($queryParams as $queryParam) {
            $param = explode('=', $queryParam);
            $assocQueryParams += [$param[0] => urldecode($param[1])];
        }
        return $assocQueryParams;
    }

    public function parseCurrentURL() {
        return explode('/', $_REQUEST['url'] ?? '');
    }

    public function getCurrentController() {
        return $this->parseCurrentURL()[0];
    }

    public function getCurrentAction() {
        return $this->parseCurrentURL()[1];
    }

}
