<?php

namespace App\Services\API;

use App\Models\CustomerOrder;
use App\Exceptions\CustomerOrderNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class CustomerOrderService
{
    /** @var \App\Models\CustomerOrder */
    protected $customer;

    public function __construct(CustomerOrder $customer)
    {
        $this->customer = $customer;
    }

    public function create(array $params)
    {
        $customer = $this->customer->create($params);

        return $customer;
    }

    public function findById(int $id): CustomerOrder
    {
        $customers = $this->customer->find($id);

        if (!($customers instanceof CustomerOrder)) {
            throw new CustomerOrderNotFoundException();
        }

        return $customers;
    }

    public function getAllCustomer()
    {
        $customers = $this->customer->get();

        return $customers;
    }
    
    public function delete(int $id)
    {
        $customer = $this->findById($id);
        $customer->delete();

        return true;
    }
}
