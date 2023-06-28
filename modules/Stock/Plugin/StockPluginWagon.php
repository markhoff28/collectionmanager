<?php

namespace modules\Stock\Plugin;

use application\AbstractPlugin;
use application\Template;
use modules\Stock\StockFacade;

/**
 * @method StockFacade getFacade()()
 */
class StockPluginWagon extends AbstractPlugin implements StockPluginInterface
{
    private const ENTITY_TYPE = 'wagon';
    private const FORM_KEY = 'wagonStock';

    public function execute()
    {
        $trainStock = $this->getStock(self::ENTITY_TYPE);

        $view =  new Template($this->getModule(), 'index', false);
        $view->bindParam('content', 'testContent');
        $view->setView('stockForm');
        $view->bindParam('moduleName', $this->getModule());
        $view->bindParam('reserved', $this->getReserved(self::ENTITY_TYPE));
        $view->bindParam('formkey', self::FORM_KEY);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formKey'] == self::FORM_KEY) {
            if ($trainStock === null) {
                $this->getFacade()->getFactory()->getRepository()->insertStockValue(
                    $this->getId(),
                    $_POST['stock'],
                    self::ENTITY_TYPE
                );
            } else {
                $this->getFacade()->getFactory()->getRepository()->updateStockValue(
                    $this->getId(),
                    $_POST['stock'],
                    self::ENTITY_TYPE,
                    $this->getReserved(self::ENTITY_TYPE)
                );
            }

            $trainStock = $this->getStock(self::ENTITY_TYPE);
        }

        $view->bindParam('stock', $trainStock ?? 0);
        $view->render();
    }

    protected function getId()
    {
        $id = $this->getQueryParams()[0]?? null;
        if ($id == null) {
            throw new \Exception('ID required');
        }
        return $id;
    }

    private function getQueryParams(): array
    {
        $queryParams = explode('/', $_REQUEST['url'] ?? '');
        if(count($queryParams) > 3) {
            return [];
        }
        return array_slice($queryParams, 2, count($queryParams));
    }

    /**
     * @return int|null
     * @throws \Exception
     */

}
