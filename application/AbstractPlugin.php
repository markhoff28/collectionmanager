<?php

namespace application;

class AbstractPlugin
{
    public function getFacade() {
        $moduleName = $this->getModule();
        $facade = sprintf('modules\%s\%sFacade',$moduleName, $moduleName);
        return new $facade;
    }

    protected function getModule() {
        $moduleName = explode('\\', get_called_class()) [1];
        return $moduleName;
    }

    public function execute() {
        $view =  new Template($this->getModule(), 'index', false);
        $view->bindParam('content', 'testContent');

        $view->setView('detailform');
        $view->bindParam('moduleName', $this->getModule());
        $view->render();
    }

    public function getStock($modul): ?int
    {
        $trainStock = $this->getFacade()->getFactory()->getRepository()->getQuantity($this->getId(), $modul);

        if (empty($trainStock)) {
            return null;
        }
        return $trainStock[0]->stock ?? null;
    }

    /**
     * @return int|null
     * @throws \Exception
     */
    public function getReserved($modul): ?int
    {
        $trainStock = $this->getFacade()->getFactory()->getRepository()->getQuantity($this->getId(), $modul);

        if (empty($trainStock)) {
            return null;
        }
        return $trainStock[0]->reserved ?? null;
    }
}
