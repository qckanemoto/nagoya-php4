<?php

namespace Nagoya\Doukaku;

class Customer
{
    public $size;
    public $isBlocker;

    public function __construct($size, $isBlocker = false)
    {
        $this->size = (int)$size;
        $this->isBlocker = (boolean)$isBlocker;
    }
}
