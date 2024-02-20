<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CustomerOrder;
use App\Exceptions\CustomerOrderNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    /** @var array */
    protected $data;

    /** @var int */
    private static $ID;

    /** @var array */
    private static $CUSTOMER;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $CUSTOMER = CustomerOrder::find(self::$ID);
    }

    /**
     * CustomerTest constructor.
     */
    public function __construct($name = 'CustomerTest')
    {
        parent::__construct($name);
        $this->createApplication();

        $this->data = [
            'name' => 'Burger',
            'status' => 'DineIn',
        ];
    }

    public function testCreateMissingParams()
    {
        foreach (array_keys($this->data) as $key) {
            $data = $this->data;
            unset($data[$key]);
            $response = $this->json('POST', '/v1/customer/order', $data);
            $response->assertStatus(422)
                ->assertJson([
                    'error' => [
                        $key => ["The $key field is required."],
                    ]
                ]);
        }
    }

    public function testCreate()
    {
        $response = $this->json('POST', '/v1/customer/order', $this->data);
        $response->assertStatus(200)
            ->assertJson([ 'data' => $this->data ]);
        $result = $response->getData();
        self::$ID = $result->data->id;
    }

    public function testReadCustomerOrderNotFound()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/customer/order/999999');
        $response->assertStatus(500)
            ->assertJson([ 
                'error' => (new CustomerOrderNotFoundException())->getMessage(),
            ]);
    }

    public function testCustomerOrderRead()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/customer/order/1');
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $this->data['name'],
                    'status' => $this->data['status'],
                ],
            ]);
    }

    public function testGetAllCustomer()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/customer/list');
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                ],
            ],
        ]);
    }
    public function testDeleteCustomer()
    {
        $response = $this->json('DELETE', '/' . config('app.api_version') . '/customer/'. 3);
        $response->assertStatus(200);
    }    
}
