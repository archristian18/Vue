<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\API\CustomerOrderService;
use App\Http\Resources\CustomerOrderResource;
use App\Http\Requests\API\Customer\CreateCustomerOrderRequest;

class CustomerOrderController extends Controller
{
    /** @var \App\Services\API\CustomerOrderService */
    protected $customerService;

    public function __construct(CustomerOrderService $customerService)
    {
        parent::__construct();
        $this->customerService = $customerService;
    }
    /**
     * Create New Customer Order
     *
     * @param \App\Http\Requests\API\Customer\CreateCustomerOrderRequest $request
     * 
     */
    public function create(CreateCustomerOrderRequest $request)
    {
        $request->validated();

        try {
            $formData = [
                'name' => $request->getName(),
                'status' => $request->getStatus(),
            ];
            $customer = $this->customerService->create($formData);
            $this->response['data'] = new CustomerOrderResource($customer);

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
            $customer = $this->customerService->findById($id);
            $this->response['data'] = new CustomerOrderResource($customer);
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
    public function getCustomer()
    {
        try {
            $customer = $this->customerService->getAllCustomer();
            $this->response['data'] = $customer;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    public function delete($id)
    {
        try {
            $this->response['deleted'] = $this->customerService->delete((int) $id);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }
}
