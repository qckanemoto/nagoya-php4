<?php

namespace Nagoya\Doukaku;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function 客が並ぶ()
    {
        $register = new Register(1, 0);

        $register->enqueue(new Customer(1));
        $register->enqueue(new Customer(2));
        $register->enqueue(new Customer(3, true));
        $register->enqueue(new Customer(4));
        $register->enqueue(new Customer(5, false));

        $customers = $register->getCustomers();

        $this->assertEquals(1, $customers[0]->size);
        $this->assertEquals(2, $customers[1]->size);
        $this->assertEquals(3, $customers[2]->size);
        $this->assertTrue($customers[2]->isBlocker);
        $this->assertEquals(4, $customers[3]->size);
        $this->assertEquals(5, $customers[4]->size);
        $this->assertFalse($customers[4]->isBlocker);
    }

    /**
     * @test
     */
    public function 列の長さを返す()
    {
        $register = new Register(1, 0);

        $register->enqueue(new Customer(3));
        $register->enqueue(new Customer(1));
        $register->enqueue(new Customer(100));
        $register->enqueue(new Customer(1000));
        $this->assertEquals(1104, $register->getLength());
    }

    /**
     * @test
     */
    public function 客を処理する_キャパより大きい団体()
    {
        $register = new Register(1, 10);

        $register->enqueue(new Customer(13));
        $register->process();
        $this->assertEquals(3, $register->getLength());
    }

    /**
     * @test
     */
    public function 客を処理する_キャパより大きい団体で次もいる()
    {
        $register = new Register(1, 5);
        $register->enqueue(new Customer(6));
        $register->enqueue(new Customer(3));
        $register->process();
        $this->assertEquals(4, $register->getLength());
    }

    /**
     * @test
     */
    public function 客を処理する_キャパより小さい団体と次の団体()
    {
        $register = new Register(1, 10);

        $register->enqueue(new Customer(2));
        $register->enqueue(new Customer(3));
        $register->enqueue(new Customer(10));
        $register->process();
        $this->assertEquals(5, $register->getLength());
    }

    /**
     * @test
     */
    public function ブロッカーは処理されない()
    {
        $register = new Register(1, 3);

        $register->enqueue(new Customer(1, true));
        $register->process();
        $this->assertEquals(1, $register->getLength());
    }

    /**
     * @test
     */
    public function ブロッカーの手前までは処理される()
    {
        $register = new Register(1, 3);

        $register->enqueue(new Customer(2));
        $register->enqueue(new Customer(1, true));
        $register->process();
        $this->assertEquals(1, $register->getLength());
    }

    /**
     * @test
     */
    public function 列の長さはマイナスにはならない()
    {
        $register = new Register(1, 10);

        $register->enqueue(new Customer(3));
        $register->process();
        $this->assertEquals(0, $register->getLength());
    }

    /**
     * @test
     */
    public function ブロッカーがいても後ろに並ぶことはできる()
    {
        $register = new Register(1, 3);

        $register->enqueue(new Customer(1, true));
        $register->enqueue(new Customer(4));
        $this->assertEquals(5, $register->getLength());
    }
}
