<?php

namespace modules\Calculator\Calculator;

interface OperatorInterface
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param int $number1
     * @param int $number2
     *
     * @return int
     */
    public function calculate(int $number1, int $number2): int;
}
