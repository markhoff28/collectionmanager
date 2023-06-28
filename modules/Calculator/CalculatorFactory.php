<?php

namespace modules\Calculator;

use application\AbstractFactory;
use modules\Calculator\Calculator\AdditionOperator;
use modules\Calculator\Calculator\Calculator;
use modules\Calculator\Calculator\OperatorInterface;
use modules\Calculator\Calculator\SubtractionOperator;

class CalculatorFactory extends AbstractFactory
{
    /**
     * @return Calculator
     */
    public function createCalculator(): Calculator {
        return new Calculator(
            $this->getOperators()
        );
    }

    /**
     * @return OperatorInterface[]
     */
    private function getOperators(): array {
        return [
            new AdditionOperator(),
            new SubtractionOperator(),
        ];
    }
}
