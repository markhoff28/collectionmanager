<?php

namespace modules\Wagon;

use application\AbstractFacade;

/**
 * @method WagonFactory getFactory()
 */
class WagonFacade extends AbstractFacade
{
    public function getWagons($sortColumn, $sortDirection, $searchKeyword) {
        return $this->getFactory()->getRepository()->queryAllWagons($sortColumn, $sortDirection, $searchKeyword);
    }

    public function getWagonById($id) {
        return $this->getFactory()->getRepository()->queryWagonByID($id);
    }

    public function createWagon($data) {
        return $this->getFactory()->getRepository()->insertWagon($data);
    }

    public function updateWagon($id, $data) {
        return $this->getFactory()->getRepository()->updateWagon($id, $data);
    }

    public function deleteWagonById($id) {
        return $this->getFactory()->getRepository()->deleteWagonById($id);
    }
}