<?php

namespace modules\Calculator;

use application\AbstractController;

/**
 * @method CalculatorFactory getFactory()
 */
class CalculatorController extends AbstractController
{
    public function indexAction() {
        $calculator = $this->getFactory()->createCalculator();

        $this->view->setView('calculatorForm');
        $this->view->bindParam('operators', $calculator->getOperators());

        $operatorKey = $_POST['operator'] ?? '';
        $this->view->bindParam('operatorKey', $operatorKey);

        if($this->calculationFormWasSend()) {
            $number1 = $_POST['number1'] ?? 0;
            $number2 = $_POST['number2'] ?? 0;
            $this->view->bindParam('numbers', [$number1, $number2]);

            try {
                return $calculator->calculate(
                    $number1,
                    $number2,
                    $operatorKey
                );
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }
        }

        return 'Currently no calculation executed';
    }

    /**
     * @return bool
     */
    private function calculationFormWasSend(): bool {
        if($_POST['calculate'] ?? false) {
            return ($_POST['calculate'] ==='=');
        }

        return false;
    }
}
