<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    /** @var array */
    protected $data;

    /** @var int */
    private static $ID;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // cleanup test data
        $menu = Menu::find(1);
    }

    /**
     * MenuTest constructor.
     */
    public function __construct($name = 'MenuTest')
    {
        parent::__construct($name);
        $this->createApplication();

        $imagePath = storage_path('images/classic.jpg');

        $this->data = [
            'name' => 'Classic Burger',
            'price' => 110.00,
            'description' => 'Quarter pound, cheese, sauce, tomato & with ice tea',
            'image_path' => 'images/classic.jpg',
        ];
    }

    public function testCreateMissingParams()
    {
        // Simulate file upload
        $filePath = storage_path('app/public/images/classic.jpg');
        Storage::disk('public')->putFileAs('', $filePath, 'images/classic.jpg');
        $file = new UploadedFile($filePath, 'images/classic.jpg', 'image/jpeg', null, true);

        $params = [
            'price' => 110.00,
            'description' => 'Quarter pound, cheese, sauce, tomato & with ice tea',
            'image_path' => $file,
        ];

        $response = $this->json('POST', '/' . config('app.api_version') . '/order/menu/add', $params);
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name field is required.'],
                ],
            ]);
    
        // Clean up the uploaded file after the test
        Storage::disk('public')->delete('path/to/uploaded/file/classic.jpg');
    }

    public function testCreate()
    {
        // Simulate file upload
        $filePath = storage_path('app/public/images/classic.jpg');
        Storage::disk('public')->putFileAs('', $filePath, 'images/classic.jpg');
        $file = new UploadedFile($filePath, 'images/classic.jpg', 'image/jpeg', null, true);

        $params = [
            'name' => 'Classic Burger',
            'price' => 110.00,
            'description' => 'Quarter pound, cheese, sauce, tomato & with ice tea',
            'image_path' => $file
        ];

        $response = $this->json('POST', '/' . config('app.api_version') . '/order/menu/add', $params);
        $response->assertStatus(200);
    
        // Clean up the uploaded file after the test
        Storage::disk('public')->delete('path/to/uploaded/file/classic.jpg');
    }
    

    public function testGetList()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/menu');
        $response->assertStatus(200);
    }

    public function testRead()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/order/menu' . 1);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $this->data['name'],
                    'price' => $this->data['price'],
                    'description' => $this->data['description'],
                    'image_path' => $this->data['image_path'],
                ],
            ]);
    }


    public function testEditMenu()
    {
        // Simulate file upload
        $filePath = storage_path('app/public/images/classic.jpg');
        Storage::disk('public')->putFileAs('', $filePath, 'images/classic.jpg');
        $file = new UploadedFile($filePath, 'images/classic.jpg', 'image/jpeg', null, true);
        
        $params = [
            'id' => 6,
            'name' => 'Hawaiian Burger',
            'price' => 115.00,
            'description' => 'Quarter pound patty, loaded with bacon cheese sauce, lettuce, tomato, caramelized onion & with ice tea',
            'image_path' => $file,
        ];

        $response = $this->json('POST', '/' . config('app.api_version') . '/order/menu', $params);
        $response->assertStatus(200);

        // Clean up the uploaded file after the test
        Storage::disk('public')->delete('path/to/uploaded/file/classic.jpg');
    }
    
    public function testDeleteMenu()
    {
        $response = $this->json('DELETE', '/' . config('app.api_version') . '/order/menu/'. 7);
        $response->assertStatus(200);
    }
}
