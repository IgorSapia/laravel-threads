<?php

namespace App\Handlers;

class teste
{
    protected $newAmount;
    protected $customerId;

    public function __construct($newAmount, $customerId)
    {
        $this->newAmount = $newAmount;
        $this->customerId = $customerId;
    }

    public function handle()
    {
        return [
            'amount' => $this->newAmount,
            'customer' => $this->customerId
        ];
        // dd($this->newAmount, $this->customerId);
    }
}
