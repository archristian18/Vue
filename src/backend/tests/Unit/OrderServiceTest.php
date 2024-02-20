<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\OrderList;
use App\Services\API\OrderListService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class OrderServiceTest extends TestCase
{
    /** @var array */
    private $data;

    /** @var array */
    private static $ORDER;

    /** @var OrderListService */
    private $service;

    /** @var string */
    private static $KEYWORD = 'ad';

    /** @var int */
    private static $TOTAL;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    /**
     * MenuServiceTest constructor.
     * @return void
     */
    public function __construct($name = 'OrderServiceTest')
    {
        parent::__construct($name);

        $this->data = [
            'customer_id' => 9999,
            'quantity' => [1],
            'total_price' => [110],
            'menu_id' => [1],
        ];

        $this->service = new OrderListService(new OrderList());
    }

    public function testCreateMissingField()
    {
        $this->expectException('Illuminate\Database\QueryException');

        $data = $this->data;

        $this->service->create($data);
    }

    public function testGetInvalidParamType()
    {
        $this->expectException('TypeError');

        $this->service->getCustomerOrder('params');
    }

    public function testGetOrderListWithMenu()
    {
        $orderList = OrderList::with('menus')->find(1);

        // call to Array since default is Collection Class by Laravel
        $this->assertTrue(is_array($orderList->menus->toArray()));
        $this->assertEquals($orderList->menus->id, $orderList->menu_id);
    }

    public function testGetOrderListWithCustomer()
    {
        $orderList = OrderList::with('customer_orders')->find(1);

        // call to Array since default is Collection Class by Laravel
        $this->assertTrue(is_array($orderList->customer_orders->toArray()));
        $this->assertEquals($orderList->customer_orders->id, $orderList->customer_id);
    }
}
