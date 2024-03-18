<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;


class CustomerRepository extends Repository
{
    protected $model = Customer::class;

    public function store($customerData){
        return $this->model::create($customerData);
    }

    public function update($id, $customerData){
        return $this->model::where('id', $id)->update($customerData);
    }

    public function getAmount($id){
        return $this->model::select('amount')->where('id', $id)->first();
    }

    public function checkCustomer($id){
        return $this->model::findOrFail($id);
    }
}
