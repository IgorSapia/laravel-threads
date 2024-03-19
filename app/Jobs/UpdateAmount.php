<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Repositories\CustomerRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


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
        try{
            $amount = $this->customerService->getAmount($this->customerDbData['id']);

            if($this->newAmount > $amount->amount){
                $customerToUpdate = [
                    'name' => $this->customerDbData['name'],
                    'amount' => $this->newAmount,
                    'before_amount' => $this->customerDbData['amount']
                ];

                $this->customerService->update($this->customerDbData['id'], $customerToUpdate);
            }
        }catch(Exception $error){
            Log::error(["Error Update Amount Job" => $error->getMessage()]);
        }
    }
}
