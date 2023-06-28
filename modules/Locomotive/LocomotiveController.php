<?php

namespace modules\Locomotive;

use application\AbstractController;

/**
 * @method LocomotiveFacade getFacade()
 * @method LocomotiveFactory getFactory()
 */
class LocomotiveController extends AbstractController
{
    public function indexAction() {
        $locomotiveTable = $this->getFactory()->createLocomotiveTable($this);

        $this->view->setView('table');
        $this->view->bindParam('tableSearch', $locomotiveTable->getTableSearchAttributes());
        $this->view->bindParam('moduleName', $locomotiveTable->getModuleName());

        return $locomotiveTable->getViewData();
    }

    public function detailAction() {
        $locomotiveDetails = $this->getFactory()->createLocomotiveDetails();

        $this->view->bindParam('detailAttribute', $locomotiveDetails->createDetailsAttribute());
        $this->view->bindParam('moduleName', $locomotiveDetails->getModuleName());
        $this->view->bindParam('widgetPlugins', $this->getFactory()->getDetailPlugins());

        if (!$this->getFacade()->getLocomitiveById($this->getLocomotiveID()) == null) {
            return $this->getFacade()->getLocomitiveById($this->getLocomotiveID());
        } else {
            return $this->pageNotFound();
        }

    }

    public function createAction() {
        $form = $this->getFactory()->createLocomotiveForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Create');
        $this->view->bindParam('moduleName', $form->getModuleName());


        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->createLocomotive(
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Locomotive');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm());
    }

    public function updateAction() {
        $form = $this->getFactory()->createLocomotiveForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Update');
        $this->view->bindParam('moduleName', $form->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->updateLocomotice(
                    $this->getLocomotiveID(),
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Locomotive');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm($this->getLocomotiveID()));
    }

    public function deleteAction() {
        $this->view->bindParam('moduleName', $this->getFactory()->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->getFacade()->deleteLocomitiveById($this->getLocomotiveID())) {
                header('Location: /mvcSammlungsverwaltung/Locomotive');
            } else {
                die('Something went wrong!');
            }
        }

        return $this->getLocomotiveID();
    }

    protected function getLocomotiveID() {
        $id = $this->getQueryParams()[0]?? null;
        if ($id == null) {
            throw new \Exception('ID required');
        }
        return $id;
    }
}
