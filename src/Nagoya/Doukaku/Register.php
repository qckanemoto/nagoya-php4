<?php

namespace Nagoya\Doukaku;

class Register
{
    private $index;
    private $capability;
    private $customers;

    function __construct($index, $capability)
    {
        $this->index = $index;
        $this->capability = $capability;
        $this->customers = new \SplQueue();
    }

    /**
     * @param Customer $customer
     */
    public function enqueue(Customer $customer)
    {
        $this->customers->enqueue($customer);
        return $this;
    }

    public function process()
    {
        $capability = $this->capability;
        foreach ($this->customers as $customer) {
            if ($customer->isBlocker) {
                break;
            }
            if ($capability >= $customer->size) {
                $this->customers->dequeue();
                $capability -= $customer->size;
            } else {
                $key = $this->customers->key();
                $this->customers[$key]->size -= $capability;
                $capability = 0;
            }
        }
        return $this;
    }

    public function getLength()
    {
        $length = 0;
        foreach ($this->customers as $customer) {
            $length += $customer->size;
        }
        return $length;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return \SplQueue
     */
    public function getCustomers()
    {
        return $this->customers;
    }
}
