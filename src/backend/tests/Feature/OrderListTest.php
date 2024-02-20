<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CustomerOrder;
use App\Models\OrderList;
use Illuminate\Support\Facades\Log;
use App\Exceptions\OrderListNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderListTest extends TestCase
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
    public function __construct($name = 'OrderListTest')
    {
        parent::__construct($name);
        $this->createApplication();

        $this->data = [
            'quantity' => 1,
            'menu_id' => 1,
            'total_price' => 110,
            'customer_id' => 1,
        ];
    }

    public function testCreateMissingParams()
    {
        $params = [
            'quantity' => [1],
            'menu_id' => [1],
            'total_price' => [110],
        ];

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
        $params = [
            'quantity' => [1],
            'menu_id' => [1],
            'total_price' => [110],
            'customer_id' => 2,
        ];

        $response = $this->json('POST', config('app.api_version') . '/order/list', $params);
        $response->assertStatus(200);
    }

    public function testReadOrderListNotFound()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/list/999999');
        $response->assertStatus(500)
            ->assertJson([ 
                'error' => (new OrderListNotFoundException())->getMessage(),
            ]);
    }

    public function testOrderListRead()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/list/' . 1);
        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'data' => [
                    'customer_id' => $this->data['customer_id'],
                    'quantity' => $this->data['quantity'],
                    'total_price' => $this->data['total_price'],
                    'menu_id' => $this->data['menu_id'],
                ],
            ]);
    }

    public function testOrderReceiptRead()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/receipt/' . 1);
        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'data' => [
                    [
                        'quantity' => 1,
                        'total_price' => 110,
                        'customer_id' => 1,
                        'menu_name' => 'Classic Burger',
                        'status' => 'DineIn',
                        'customer_name' => 'Burger',
                        'price' => 110,
                    ],
                ],
            ]);
    }
    
    public function testUpdateString()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/receipt/' . 'test');
        $response->assertStatus(500);
    } 
}
