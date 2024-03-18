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
use Illuminate\Support\Facades\DB;


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
        DB::beginTransaction();
        try{
            $amount = $this->customerService->getAmount($this->customerDbData['id']);
            Log::info(['amountss' => $this->newAmount, 'amouuunt' => $amount]);
            if($this->newAmount > $amount->amount){
                $customerToUpdate = [
                    'name' => $this->customerDbData['name'],
                    'amount' => $this->newAmount,
                    'before_amount' => $this->customerDbData['amount']
                ];

                $this->customerService->update($this->customerDbData['id'], $customerToUpdate);
            }

            DB::commit();
        }catch(Exception $error){
            Log::error(["Error Update Amount Job" => $error->getMessage()]);
            DB::rollBack();
        }
    }
}
