<?php

namespace modules\Calculator\Calculator;

class SubtractionOperator implements OperatorInterface
{

    public function getKey(): string
    {
        return 'substraction';
    }

    public function getLabel(): string
    {
        return '-';
    }

    public function calculate(int $number1, int $number2): int
    {
        return $number1 - $number2;
    }
}
