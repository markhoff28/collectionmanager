<?php

namespace modules\Locomotive;

use application\AbstractFacade;

/**
 * @method LocomotiveFactory getFactory()
 */
class LocomotiveFacade extends AbstractFacade
{
    public function getLocomotives($sortColumn, $sortDirection, $searchKeyword) {
        return $this->getFactory()->getRepository()->queryAllLocomotives($sortColumn, $sortDirection, $searchKeyword);
    }

    public function getLocomitiveById($id) {
        return $this->getFactory()->getRepository()->queryLocomotiveByID($id);
    }

    public function createLocomotive($data) {
        return $this->getFactory()->getRepository()->insertLocomotive($data);
    }

    public function updateLocomotice($id, $data) {
        return $this->getFactory()->getRepository()->updateLocomotive($id, $data);
    }

    public function deleteLocomitiveById($id) {
        return $this->getFactory()->getRepository()->deleteLocomotiveById($id);
    }
}