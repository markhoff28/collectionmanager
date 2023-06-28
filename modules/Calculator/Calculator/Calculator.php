<?php

namespace modules\Calculator\Calculator;

class Calculator
{
    /**
     * @var OperatorInterface[]
     */
    private $operators = [];

    /**
     * @param OperatorInterface[] $operators
     */
    public function __construct(
        array $operators
    )
    {
        $this->operators = $operators;
    }

    /**
     * @param int $number1
     * @param int $number2
     * @param string $operatorKey
     *
     * @return int
     */
    public function calculate(
        int $number1,
        int $number2,
        string $operatorKey
    ): int {
        foreach ($this->operators as $operator) {
            if ($operatorKey == $operator->getKey()) {
                return $operator->calculate($number1, $number2);
            }
        }

        throw new \Exception('No Calculator found');
    }

    /**
     * @return array
     */
    public function getOperators(): array
    {
        $operators = [];
        foreach ($this->operators as $operator) {
            if(!$operator instanceof OperatorInterface) {
                throw new \Exception('Operator needs to implement OperatorInterface');
            }
            $operators[] = [
                'key' => $operator->getKey(),
                'label' => $operator->getLabel()
            ];
        }
        return $operators;
    }
}
