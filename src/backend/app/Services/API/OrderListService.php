<?php

namespace App\Services\API;

use DB;
use Exception;
use App\Models\OrderList;
use App\Http\Resources\OrderListResource;
use App\Exceptions\OrderListNotFoundException;

class OrderListService
{
    /** @var \App\Models\OrderList */
    protected $orderList;

    public function __construct(OrderList $orderList)
    {
        $this->orderList = $orderList;
    }

    public function create(array $params)
    {
        try {
            $customer_orders = [];
        
            // Check if 'quantity' is an array in the input data
            if (is_array($params['quantity'])) {
                foreach ($params['quantity'] as $key => $quantity) {
                    $menu_id = $params['menu_id'][$key];
                    $total_price = $params['total_price'][$key];
        
                    if ($quantity > 0) {
                        $customer_order = [
                            'quantity' => $quantity,
                            'menu_id' => $menu_id,
                            'total_price' => $total_price,
                            'customer_id' => $params['customer_id'],
                        ];

                        $customer = OrderList::create($customer_order);
                        $customer_orders[] = $customer_order;
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }

        return $customer_orders;
    }

    public function findById(int $id): OrderList
    {
        $orderList = $this->orderList->find($id);

        if (!($orderList instanceof OrderList)) {
            throw new OrderListNotFoundException();
        }

        return $orderList;
    }

    public function getCustomerOrder(int $id)
    {
        $orders = DB::table('order_lists')
            ->join('customer_orders', 'order_lists.customer_id', '=', 'customer_orders.id')
            ->join('menus', 'order_lists.menu_id', '=', 'menus.id')
            ->select('quantity', 'total_price', 'customer_id', 'menus.name as menu_name', 
                    'status', 'customer_orders.name as customer_name', 'price')
            ->where('customer_id', $id)
            ->get();

        return $orders;
    }
    
}
