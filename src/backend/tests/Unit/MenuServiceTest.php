<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\OrderList;
use App\Services\API\MenuService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MenuServiceTest extends TestCase
{
    /** @var array */
    private $data;

    /** @var array */
    private static $MENU;

    /** @var MenuService */
    private $service;

    /** @var string */
    private static $KEYWORD = 'ad';

    /** @var int */
    private static $TOTAL;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // self::$MENU = Menu::find(1);
    }

    /**
     * MenuServiceTest constructor.
     * @return void
     */
    public function __construct($name = 'MenuServiceTest')
    {
        parent::__construct($name);

        $this->data = [
            'name' => 'Classic Burger',
            'price' => 110.00,
            'description' => 'Quarter pound, cheese, sauce, tomato & with ice tea',
            'image_path' => UploadedFile::fake()->create('thumbnail.jpg'),
        ];

        $this->service = new MenuService(new Menu());
    }


    public function testCreateInvalidParamType()
    {
        $this->expectException('TypeError');

        $this->service->create('params');
    }

    public function testCreateMissingField()
    {
        $this->expectException('Illuminate\Database\QueryException');

        $data = $this->data;
        unset($data['name']);

        $this->service->create($data);
    }

    public function testFindbyIdMenuNotFound()
    {
        $this->expectException('App\Exceptions\MenuNotFoundException');
        $this->expectExceptionMessage('Unable to retrieve menu');

        $this->service->findByMenu(9999999999999);
    }

    public function testGetAllOrder_list()
    {
        $menus = Menu::with('order_lists')->find(1);
        // call to Array since default is Collection Class by Laravel
        $this->assertTrue(is_array($menus->order_lists->toArray()));

        foreach ($menus->order_lists as $order_list) {
            $this->assertEquals($order_list->menu_id, $menus->id);
        }
    }

    public function testUpdateMissing()
    {
        $this->expectException('ErrorException');
    
        $formData = [
            'id' => 6,
            'name' => 'asdas',
            'price' => 160.00,
            'description' => 'Quarter pound patty, loaded with bacon cheese sauce, lettuce, tomato, caramelized onion & with ice tea',
            'image_path' => UploadedFile::fake()->create('thumbnail.jpg'),
        ];
    
        unset($formData['name']);
    
        $this->service->update($formData);
    }    
}
