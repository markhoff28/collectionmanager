<?php

namespace modules\Train;

use application\AbstractController;
use modules\Train\Reader\TrainReader;
use modules\Train\Transfer\TrainTransferSegment;

/**
 * @method TrainFacade getFacade()
 * @method TrainFactory getFactory()
 * @method TrainReader getReader()
 */
class TrainController extends AbstractController
{
    public function indexAction() {
        //echo "<a href=\"".$this->createUrl([], 'details', 'wagon')."\">Test</a>";
        $trainTable =  $this->getFactory()->createTrainTable($this);

        $this->view->setView('table');
        $this->view->bindParam('tableSearch', $trainTable->getTableSearchAttributes());
        $this->view->bindParam('moduleName', $trainTable->getModuleName());

        return $trainTable->getViewData();
    }

    public function detailAction(int $idTrain) {
        $trainDetails = $this->getFactory()->createTrainDetails($this);
        $assocQueryParams = $this->getAssocQueryParams();

        $this->view->setView('detailTable');
        $this->view->bindParam('tableColumnData', $trainDetails->getTableHead());
        $this->view->bindParam('tableSearch', $trainDetails->getTableSearchAttributes());
        $this->view->bindParam('tableAction', $trainDetails->getActions());
        $this->view->bindParam('moduleName', $trainDetails->getModuleName());
        $this->view->bindParam('tableName', 'train');
        $this->view->bindParam('trainId', $idTrain);

        if (!$this->getFacade()->getTrainById($idTrain) == null) {
            $trainDetails->setTrainId($idTrain);
            //return $trainDetails->getViewData();
            return $this->getReader()->generateTrain(
                $idTrain
            );
        } else {
            return $this->pageNotFound();
        }
    }

    /**
     * Handling von Zuegen
    */

    public function createAction() {
        //TODO: auswahl der Spurbreite beim kreieren + persistieren Done

        $form = $this->getFactory()->createTrainForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Create');
        $this->view->bindParam('moduleName', $form->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->createTrain(
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Train');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm());
    }

    public function updateAction(int $idTrain) {
        $form = $this->getFactory()->createTrainForm();
        $this->view->setView('form');
        $this->view->bindParam('action', 'Update');
        $this->view->bindParam('moduleName', $form->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($form->validateForm()) {
                $this->getFacade()->updateTrain(
                    $idTrain,
                    $form->getFormValues()
                );
                header('Location: /mvcSammlungsverwaltung/Train');
            }
        }

        $this->view->bindParam('formContent', $form->generateForm($idTrain));
    }

    public function deleteAction(int $idTrain) {
        $this->view->bindParam('moduleName', $this->getFactory()->getModuleName());

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->getFacade()->deleteTrainById($idTrain)) {
                header('Location: /mvcSammlungsverwaltung/Train');
            } else {
                die('Something went wrong!');
            }
        }

        return $idTrain;
    }

    /**
     * Handling vom Zugaufbau
     */

    public function linkToSegmentAction(int $idtrain) {

    }

    public function addSegmentAction(int $fkTrain) {
        $form = $this->getFactory()->createTrainDetailForm();
        $train = $this->getFacade()->getTrainById($fkTrain);

        $this->view->setView('sonderform');
        $this->view->bindParam('action', 'Composition');
        $this->view->bindParam('moduleName', $form->getModuleName());
        $this->view->bindParam('locomotives', $this->getReader()->getLocomotives(
            $train
        ));
        $this->view->bindParam('wagons', $this->getReader()->getWagons(
            $train
        ));

        $this->view->bindParam('trainId', $train[0]->id_train);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $trainSegmenttransfer = (new TrainTransferSegment())
                ->fromArray($form->getFormValues(), true)
                ->setFkTrain($fkTrain);

            if($this->getFactory()->createTrainWriter()->addSegment($trainSegmenttransfer)) {
                header('Location: /mvcSammlungsverwaltung/Train/detail/' . $fkTrain);
            } else {
                // fehlermeldung?!?
            }
        }

        $this->view->bindParam('formContent', $form->generateForm());
    }

    public function updateSegmentAction(int $idSegment) {
        $form = $this->getFactory()->createTrainDetailForm();
        $segment = $this->getFacade()->getTrainSegmentById($idSegment);
        $segmentType = '';
        if($segment[0]->fk_segmentType == 1) {
            $segmentType = 'locomotive';
        } else {
            $segmentType = 'wagon';
        }
        $oldTrainSegmenttransfer = (new TrainTransferSegment())
                ->setIdTrainSegment($idSegment)
                ->setFkTrain($segment[0]->fk_train)
                ->setFkSegmentEntity($segment[0]->fk_segmentEntity)
                ->setFkSegmentType($segment[0]->fk_segmentType)
                ->setSegmentType($segmentType);

        $this->view->setView('sonderform');
        $this->view->bindParam('action', 'Composition');
        $this->view->bindParam('moduleName', $form->getModuleName());
        $this->view->bindParam('locomotives', $this->getReader()->getLocomotives(
            $this->getFacade()->getTrainById($segment[0]->fk_train))
        );
        $this->view->bindParam('wagons', $this->getReader()->getWagons(
            $this->getFacade()->getTrainById($segment[0]->fk_train))
        );
        $this->view->bindParam('trainId', $segment[0]->fk_train);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $trainSegmenttransfer = (new TrainTransferSegment())
                ->fromArray($form->getFormValues(), true)
                ->setIdTrainSegment($idSegment)
                ->setFkSegmentType($segment[0]->fk_segmentType);

            if($this->getFactory()->createTrainWriter()->updateSegment($trainSegmenttransfer, $oldTrainSegmenttransfer)) {
                /*var_dump($trainSegmenttransfer);
                echo '<br>';
                var_dump($oldTrainSegmenttransfer);*/
                header('Location: /mvcSammlungsverwaltung/Train/detail/' . $segment[0]->fk_train);
            } else {
                // fehlermeldung?!?
            }
        }

        $this->view->bindParam('formContent', $segment);
    }

    public function deleteSegmentAction(int $idSegment) {
        $segment = $this->getFacade()->getTrainSegmentById($idSegment);

        $this->view->bindParam('moduleName', $this->getFactory()->getModuleName());

        $this->view->setView('deleteSegment');

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $segmentType = '';
            if($segment[0]->fk_segmentType == 1) {
                $segmentType = 'locomotive';
            } else {
                $segmentType = 'wagon';
            }
            var_dump($segment[0]);
            echo '<br>';
            $trainSegmenttransfer = (new TrainTransferSegment())
                ->setIdTrainSegment($idSegment)
                ->setFkTrain($segment[0]->fk_train)
                ->setFkSegmentEntity($segment[0]->fk_segmentEntity)
                ->setFkSegmentType($segment[0]->fk_segmentType)
                ->setSegmentType($segmentType);

            if($this->getFactory()->createTrainWriter()->removeSegment($trainSegmenttransfer)) {
                header('Location: /mvcSammlungsverwaltung/Train/detail/' . $segment[0]->fk_train);
            } else {
                die('Something went wrong!');
            }
        }

        return $idSegment;
    }
}
