<?php

namespace application;
use application\SystemMessages\ErrorMessages;

class Validator
{
    private $message = [];
    public function checkNumericValue($value):bool {
        return is_numeric($value);
    }

    public function checkStringValue($value):bool {
        $this->message = [];
        if (!preg_match('/^[A-z]+$/', $value)) {
            $this->message[] = ErrorMessages::ERROR_STRING_VALUE_WRONG_FORMAT;
            //return false;
        }
        if (strlen($value) < 3) {
            $this->message[] = ErrorMessages::ERROR_STRING_VALUE_TO_SHORT;
            //return false;
        }
        if (strlen($value) > 20) {
            $this->message[] = ErrorMessages::ERROR_STRING_VALUE_TO_LONG;
            //return false;
        }
        return count($this->message)===0;
    }

    public function checkSelectValue($value, $formValues, $key):bool {
        foreach ($formValues as $formValue) {
            $formValue = (array) $formValue;
            if ($formValue['id_'.$key] == $value) {
                return true;
            }
        }
        return false;
    }

    public function getMessage() {
        return implode(PHP_EOL, $this->message);
    }
}