<?php

namespace Nagoya\Doukaku;

class RegisterSelectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RegisterSelector
     */
    protected $selector;

    public function setUp()
    {
        $this->selector = new RegisterSelector();
    }

    /**
     * @test
     */
    public function 最も短いレジが選択される()
    {
        $registers = [
            (new Register(1, 0))->enqueue(new Customer(5)),
            (new Register(2, 0))->enqueue(new Customer(3)),
            (new Register(3, 0))->enqueue(new Customer(1)),
            (new Register(4, 0))->enqueue(new Customer(100)),
            (new Register(5, 0))->enqueue(new Customer(10)),
        ];

        $selected = $this->selector->select($registers);
        $this->assertEquals(3, $selected->getIndex());
    }

    /**
     * @test
     */
    public function 最も短いレジが複数ある場合は番号の若い方が選択される()
    {
        $registers = [
            (new Register(1, 0))->enqueue(new Customer(5)),
            (new Register(3, 0))->enqueue(new Customer(1)),
            (new Register(5, 0))->enqueue(new Customer(10)),
            (new Register(2, 0))->enqueue(new Customer(1)),
            (new Register(4, 0))->enqueue(new Customer(1)),
        ];

        $selected = $this->selector->select($registers);
        $this->assertEquals(2, $selected->getIndex());
    }
}
