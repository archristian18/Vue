<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CustomerOrder;
use App\Models\OrderList;
use Illuminate\Support\Facades\Log;
use App\Exceptions\OrderListNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptTest extends TestCase
{
    /** @var array */
    protected $data;

    /** @var int */
    private static $ID;

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        $orderList = OrderList::find(self::$ID);
    }

    /**
     * OrderListTest constructor.
     */
    public function __construct($name = 'ReceiptTest')
    {
        parent::__construct($name);
        $this->createApplication();

        $this->data = [
            'customer_id' => 1,
        ];
    }

    public function testGetReceipt()
    {
        $response = $this->json('GET', config('app.api_version') . '/receipt/' . 1);
        $response->assertStatus(200);
    }  

    public function testCreateWithInvalidParams()
    {
        $params = [
            'customer_id' => 9999999,
        ];
        $response = $this->json('POST', config('app.api_version') . '/receipt/', $params);
        $response->assertStatus(500);
    }

    public function testCreateMissingParams()
    {
        $params = [];

        $response = $this->json('POST', config('app.api_version') . '/order/list', $params);
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'customer_id' => ['The customer id field is required.'],
                ],
            ]);
    }

    public function testCreate()
    {
        $response = $this->json('POST', config('app.api_version') . '/receipt/', $this->data);
        $response->assertStatus(200);
    }

    public function testGetAllOrder()
    {
        $response = $this->json('GET', config('app.api_version') . '/receipt/');
        $response->assertStatus(200);
    }  
}
