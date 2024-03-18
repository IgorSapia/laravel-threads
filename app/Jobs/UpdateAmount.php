<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\CustomerService;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Log;


class UpdateAmount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newAmount;
    protected $customerDbData;
    protected $customerService;

    public function __construct($newAmount, $customerDbData)
    {
        $this->newAmount = $newAmount;
        $this->customerDbData = $customerDbData;
        $this->customerService = new CustomerService(new CustomerRepository());
    }

    public function handle(): void
    {
        $customerToUpdate = [
            'name' => $this->customerDbData['name'],
            'amount' => $this->newAmount,
            'before_amount' => $this->customerDbData['amount']
        ];

        $this->customerService->update($this->customerDbData['id'], $customerToUpdate);
    }
}
