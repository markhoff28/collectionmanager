<?php

namespace application;
use application\SystemMessages\ErrorMessages;
use application\Validator;

abstract class AbstractForm extends AbstractView
{
    /**
     * @var Validator
     */
    private $validator;
    private $formData = null;
    private $messages = [];

    abstract function getAttributesValues($key);
    abstract function getCurrentDataSet(int $dataSetId);

    public function generateForm($dataSetId = null): array {
        // ToDo Never Nester
        if ($dataSetId != null) {
            $this->formData = (array) $this->getCurrentDataSet($dataSetId);
        }

        $formValues = $this->getFormValues();
        if (count($formValues) > 0) {
            $this->formData = $formValues;
        }

        $formContent = [];

        foreach ($this->getConfig() as $key => $config) {
            $type = $config['type']?? 'p';
            switch ($type) {
                case 'select':
                    $formContent[$config['label']] = [
                        'inputType' => $this->formInputSelect($key, $this->formData[$config['columnNameFK']]?? ''),
                    ];
                    break;
                case 'number':
                    $formContent[$config['label']] = [
                        'inputType' => $this->formInputNumber($key, $this->formData[$config['columnName']]?? ''),
                    ];
                    break;
                case 'text':
                    $formContent[$config['label']] = [
                        'inputType' => $this->formInputText($key, $this->formData[$config['columnName']]?? '')
                    ];
                    break;
                default:
            }
            $formContent[$config['label']]['error'] = $this->messages[$key]?? null;
        }

        return $formContent;
    }

    public function validateForm(): bool {
        $validationStatus = true;
        foreach ($this->getConfig() as $key => $config) {
            if (!empty($_POST[$key])) {
                switch ($config['type']) {
                    case 'select':
                        $formValues[$config['columnNameFK']] = intval($_POST[$key]);
                        $selectOptions = $this->getAttributesValues($key);
                        $validationResult = $this->getValidator()->checkSelectValue($formValues[$config['columnNameFK']],$selectOptions, $key);
                        if ($validationResult == false) {
                            $this->messages[$key] = ErrorMessages::ERROR_STRING_VALUE_INALID_SELECT;
                            $validationStatus = false;
                        }
                        break;
                    case 'number':
                        $formValues[$config['columnName']] = intval($_POST[$key]);
                        $validationResult = $this->getValidator()->checkNumericValue($formValues[$config['columnName']]);
                        if ($validationResult == false) {
                            $this->messages[$key] = ErrorMessages::ERROR_STRING_VALUE_INVALID_ID;
                            $validationStatus = false;
                        }
                        break;
                    case 'text':
                        $formValues[$config['columnName']] = trim($_POST[$key]);
                        $validationResult = $this->getValidator()->checkStringValue($formValues[$config['columnName']]);
                        if ($validationResult == false) {
                            $this->messages[$key] = $this->getValidator()->getMessage();
                            $validationStatus = false;
                            //echo 'Fehler';
                        }
                        break;
                    default:
                }
            }
        }
        return $validationStatus;
    }

    public function setValidator(Validator $validator) {
        $this->validator = $validator;
    }

    public function getFormValues(): array {
        $formValues = [];
        foreach ($this->getConfig() as $key => $config) {
            if (!empty($_POST[$key])) {
                //$formValues[$config['columnName']] = $_POST[$key];
                switch ($config['type']) {
                    case 'select':
                        $formValues[$config['columnNameFK']] = intval($_POST[$key]);
                    case 'number':
                        $formValues[$config['columnName']] = floatval($_POST[$key]);
                    default:
                        $formValues[$config['columnName']] = trim($_POST[$key]);
                }
            }
        }
        return $formValues;
    }

    private function formInputText($key, $value): string {
        return '<input type="text" value="' . $value . '". " name="' . $key.'">';
    }

    private function formInputNumber($key, $value): string {
        return '<input type="number" step="0.01" value="' . $value . '". " name="' . $key.'">';
    }

    private function formInputSelect($key, $value): string {
        $selectOutput = '';
        $selectOptions = $this->getAttributesValues($key);
        $selectOutput = '<select name="' . $key.'">';
        foreach ($selectOptions as $selectOption) {
            $selectOption = (array) $selectOption;
            if ($selectOption['id_'.$key] == $value) {
                $selectOutput .= '<option value="'. $selectOption['id_'.$key] .'" selected>'. $selectOption['designation'] .'</option>';
            } else {
                $selectOutput .=  '<option value="'. $selectOption['id_'.$key] .'">'. $selectOption['designation'] .'</option>';
            }
        }
        $selectOutput .= '</select>';
        return $selectOutput;
    }

    private function getValidator(): Validator {
        if (!is_object($this->validator)) {
            $this->validator = new Validator();
        }
        return $this->validator;
    }

}
