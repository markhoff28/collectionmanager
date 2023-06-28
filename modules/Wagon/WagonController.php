<?php

namespace modules\Wagon;

use application\AbstractController;

/**
 * @method WagonFacade getFacade()
 * @method WagonFactory getFactory()
 */
class WagonController extends AbstractController
{
    public function indexAction() {
        $wagonController = $this->getFactory()->createWagonTable($this);

        $this->view->setView('table');
        $this->view->bindParam('tableColumnData', $wagonController->getTableHead());
        $this->view->bindParam('tableSearch', $wagonController->getTableSearchAttributes());
        $this->view->bindParam('tableAction', $wagonController->getActions());
        $this->view->bindParam('moduleName', $wagonController->getModuleName());
        $this->view->bindParam('tableName', 'wagon');
        return $wagonController->getViewData();
    }

    public function detailAction() {
        $wagonDetails = $this->getFactory()->createWagonDetail();

        $this->view->bindParam('detailAttribute', $wagonDetails->createDetailsAttribute());
        $this->view->bindParam('moduleName', $wagonDetails->getModuleName());
        $this->view->bindParam('widgetPlugins', $this->getFactory()->getDetailPlugins());

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($wagonDetails->getQuantityValue());
        }

        if (!$this->getFacade()->getWagonById($this->getWagonID()) == null) {
            return $this->getFacade()->getWagonById($this->getWagonID());
        } else {
            return $this->pageNotFound();
        }
    }

    public function createAction() {
        $form = $this->getFactory()->createWagonForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Create');
        $this->view->bindParam('moduleName', $form->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->createWagon(
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Wagon');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm());
    }

    public function updateAction() {
        $form = $this->getFactory()->createWagonForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Update');
        $this->view->bindParam('moduleName', $form->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->updateWagon(
                    $this->getWagonID(),
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Wagon');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm($this->getWagonID()));
    }

    public function deleteAction() {
        $this->view->bindParam('moduleName', $this->getFactory()->createWagonDelete()->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->getFacade()->deleteWagonById($this->getWagonID())) {
                header('Location: /mvcSammlungsverwaltung/Wagon');
            } else {
                die('Something went wrong!');
            }
        }

        return $this->getWagonID();
    }

    protected function getWagonID() {
        $id = $this->getQueryParams()[0]?? null;
        if ($id == null) {
            throw new \Exception('ID required');
        }
        return $id;
    }
}
