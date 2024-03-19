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
        $customer = $this->model::find($id);
        $customer->fill($customerData);
        return $customer->save();
    }

    public function getAmount($id){
        return $this->model::select('amount')->where('_id', $id)->first();
    }

    public function checkCustomer($id){
        return $this->model::find($id);
    }
}
