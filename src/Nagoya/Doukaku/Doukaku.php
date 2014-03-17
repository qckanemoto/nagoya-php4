<?php

namespace Nagoya\Doukaku;

/**
 * Nagoya.Doukaku
 *
 * @package Nagoya.Doukaku
 */
class Doukaku
{
    /**
     * @var Register[]
     */
    private $registers = [];

    /**
     * @var RegisterSelector
     */
    private $registerSelector;

    public function __construct(array $registers, $registerSelector)
    {
        $this->registers = $registers;
        $this->registerSelector = $registerSelector;
    }

    public function solve($inputString)
    {
        $inputs = str_split($inputString);
        $output = '';

        foreach ($inputs as $input) {
            if ($input == '.') {
                foreach ($this->registers as $register) {
                    $register->process();
                }
            } else {
                $target = $this->registerSelector->select($this->registers);
                if (strtolower($input) == 'x') {
                    $target->enqueue(new Customer(1, true));
                } else {
                    $target->enqueue(new Customer($input));
                }
            }
        }

        // 結果出力.
        foreach ($this->registers as $register) {
            $output[$register->getIndex()] = $register->getLength();
        }
        return implode(',', array_values($output));
    }
}
