<?php

namespace Nagoya\Doukaku;

class RegisterSelector
{
    /**
     * @param Register[] $registers
     * @return Register
     */
    public function select(array $registers)
    {
        $target = $registers[0];
        foreach ($registers as $register) {

            // 短いレジ優先.
            if ($target->getLength() > $register->getLength()) {
                $target = $register;
            } elseif ($target->getLength() === $register->getLength()) {
                // 長さが同じなら番号が若いレジ優先.
                if ($target->getIndex() > $register->getIndex()) {
                    $target = $register;
                }
            }
        }

        return $target;
    }
}
