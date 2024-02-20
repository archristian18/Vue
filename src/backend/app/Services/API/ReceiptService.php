<?php

namespace App\Services\API;

use DB;
use Exception;
use App\Models\Receipt;
use App\Models\OrderList;

class ReceiptService
{
    /** @var \App\Models\Receipt */
    protected $receipt;

    public function __construct(Receipt $receipt, OrderList $orderList)
    {
        $this->receipt = $receipt;
        $this->orderList = $orderList;
    }

    public function create(array $params)
    {
        try {
            $orderList = $this->orderList->where('customer_id', $params['customer_id'])->get("total_price")->toArray();

            $length = count($orderList);
            $receipt_payment = [];
            $data = 0;
            $receipt_payment['customer_id'] = $params['customer_id'];
            for ($count = 0; $count < $length; $count++) {
                $data = $data + $orderList[$count]['total_price'];
            }
            $receipt_payment['total_payment'] = $data;
            $receipt = $this->receipt->create($receipt_payment);

        } catch (Exception $e) {
            DB::rollback();

            throw $e;
        }

        return $receipt;
    }

    public function getReceipt(int $id)
    {
        $receipts = DB::table('receipts')
            ->join('customer_orders', 'receipts.customer_id', '=', 'customer_orders.id')
            ->where('customer_id', $id)
            ->get();

        return $receipts;
    }

    public function getAllOrder()
    {
        $receipts = DB::table('receipts')
            ->join('customer_orders', 'receipts.customer_id', '=', 'customer_orders.id')
            ->get();

        return $receipts;
    }
}
