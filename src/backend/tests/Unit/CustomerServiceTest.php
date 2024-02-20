<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\OrderList;
use App\Models\CustomerOrder;

class CustomerServiceTest extends TestCase
{
    public function testGetAllCustomer()
    {
        $customerOrder = CustomerOrder::with('order_lists')->find(1);
        // call to Array since default is Collection Class by Laravel
        $this->assertTrue(is_array($customerOrder->order_lists->toArray()));

        foreach ($customerOrder->order_lists as $order_list) {
            $this->assertEquals($order_list->customer_id, $customerOrder->id);
        }
    }
}
