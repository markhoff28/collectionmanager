<?php

namespace modules\Stock;

use application\AbstractFactory;
use application\AbstractRepository;
use modules\Trian\view\StockForm;

/**
 * @method StockRepository getRepository()
 */
class StockFactory extends AbstractFactory
{

    public function createStockForm() {
        return new StockForm(
            $this->getRepository()
        );
    }
}
