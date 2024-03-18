<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\BusinessException;
use App\Handlers\teste;
use App\Jobs\UpdateAmount;
use Illuminate\Support\Facades\Queue;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function store($customerData)
    {
        return $this->customerRepository->store($customerData);
    }

    public function edit($id, $customerData)
    {
        $customerDBData = $this->checkCustomer($id);
        $customerToUpdate = [
            'name' => $customerData['name'],
            'amount' => $customerData['amount'],
            'before_amount' => $customerDBData->amount
        ];
        return $this->update($id, $customerToUpdate);
    }

    public function update($id, $customerData){
        return $this->customerRepository->update($id, $customerData);
    }

    public function updateThread($id, $customerData)
    {
        $customerDbData = $this->checkCustomer($id);
        $amount = $customerData['amount'];

        for ($i = 0; $i < 10; $i++) {
            $job = new UpdateAmount($amount, $customerDbData);
            Queue::push($job, [], 'upload_amount');
            $amount++;
        }

        return 'Enviado para Fila';
    }

    public function getAmount($id){
        return $this->customerRepository->getAmount($id);
    }

    public function checkCustomer($id){
        return $this->customerRepository->checkCustomer($id);
    }

}

