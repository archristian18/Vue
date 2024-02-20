<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\API\ReceiptService;
use App\Http\Resources\ReceiptResource;
use App\Http\Requests\API\Receipt\CreateReceiptRequest;

class ReceiptController extends Controller
{
    /** @var \App\Services\API\receiptService */
    protected $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        parent::__construct();
        $this->receiptService = $receiptService;
    }
    /**
     * Create New Receipt Order
     *
     * @param \App\Http\Requests\API\Receipt\CreateReceiptRequest $request
     * 
     */
    public function create(CreateReceiptRequest $request)
    {
        $request->validated();

        try {
            $formData = [
                'customer_id' => $request->getCustomerId(),
            ];

            $receipt = $this->receiptService->create($formData);
            $this->response['data'] = new ReceiptResource ($receipt);

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
    public function getOrderReceipt($id)
    {
        try {
            $receipt = $this->receiptService->getReceipt($id);
            $this->response['data'] = $receipt;
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
    public function getAllOrder()
    {
        try {
            $receipt = $this->receiptService->getAllOrder();
            $this->response['data'] = $receipt;
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }
}
