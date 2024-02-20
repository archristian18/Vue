<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\API\OrderListService;
use App\Http\Resources\OrderListResource;
use App\Http\Requests\API\Order\CreateOrderListRequest;

class OrderListController extends Controller
{
    /** @var \App\Services\API\OrderListService */
    protected $orderListService;

    public function __construct(OrderListService $orderListService)
    {
        parent::__construct();
        $this->orderListService = $orderListService;
    }
    /**
     * Create New Customer Order
     *
     * @param \App\Http\Requests\API\Customer\CreateOrderListRequest $request
     * 
     */
    public function create(CreateOrderListRequest $request)
    {
        $request->validated();

        try {
            $formData = [
                'customer_id' => $request->getCustomerId(),
                'quantity' => $request->getQuantity(),
                'total_price' => $request->getTotalPrice(),
                'menu_id' => $request->getMenuId(),
            ];

            $orderList = $this->orderListService->create($formData);
            $this->response['data'] = $orderList;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Retrieves customer information
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        try {
            $orderList = $this->orderListService->findById($id);
            $this->response['data'] = new OrderListResource($orderList);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Retrieves order information
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function getOrder($id)
    {
        try {
            $orderList = $this->orderListService->getCustomerOrder($id);
            $this->response['data'] = $orderList;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }
}
