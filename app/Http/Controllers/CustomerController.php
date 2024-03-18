<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessException;


class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService){
        $this->customerService = $customerService;
    }

    public function store(CustomerRequest $request)
    {
        DB::beginTransaction();
        try{
            $storeService = $this->customerService->store($request->all());
            DB::commit();
            return response()->json($storeService, 200);
        }catch(Exception $error){
            Log::error($error->getMessage());
            DB::rollback();
        }
    }

    public function update(CustomerRequest $request, $id)
    {
        try{
            return response()->json($this->customerService->updateThread($id, $request->all()), 200);
        }catch(BusinessException $error){
            Log::error($error->getMessage());
            return response()->json($error->getMessage(), 400);
        }catch(Exception $error){
            Log::error($error->getMessage());
            return response()->json($error->getMessage(), 500);
        }
    }

    public function getAmount($id)
    {
        return response()->json($this->customerService->getAmount($id), 200);
    }
}
