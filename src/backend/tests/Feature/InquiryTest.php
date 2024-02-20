<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Inquiry;
use App\Exceptions\InquiryNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryTest extends TestCase
{
    /** @var array */
    protected $data;

    /** @var int */
    private static $ID;

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        // cleanup test data
        $inquiry = Inquiry::find(self::$ID);
    }

    /**
     * InquiryTest constructor.
     */
    public function __construct($name = 'InquiryTest')
    {
        parent::__construct($name);
        $this->createApplication();

        $this->data = [
            'fullname' => 'Test Name',
            'email' => 'test@gmail.com',
            'content' => 'TESTING',
        ];
    }

    public function testCreateMissingParams()
    {
        foreach (array_keys($this->data) as $key) {
            $data = $this->data;
            // remove key for testing missing params
            unset($data[$key]);
            $response = $this->json('POST', '/v1/inquiries', $data);

            // verify expected response
            $response->assertStatus(422)
                ->assertJson([
                    'error' => [
                        $key => ["The $key field is required."],
                    ]
                ]);
        }
    }

    public function testCreateInvalidParams()
    {
        $data = $this->data;
        $data['email'] = 'invalid@email';
        $response = $this->json('POST', '/v1/inquiries', $data);
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'email' => ['Invalid email address.'],
                ]
            ]);
    }

    public function testCreate()
    {
        $response = $this->json('POST', '/v1/inquiries', $this->data);
        $response->assertStatus(200)
            ->assertJson([ 'data' => $this->data ]);
        $result = $response->getData();
        self::$ID = $result->data->id;
    }

    public function testReadInquiryNotFound()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/inquiries/999999');
        $response->assertStatus(500)
            ->assertJson([ 
                'error' => (new InquiryNotFoundException())->getMessage(),
            ]);
    }

    public function testRead()
    {
        $response = $this->json('GET', '/' . config('app.api_version') . '/inquiries/' . 1);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'fullname' => $this->data['fullname'],
                    'email' => $this->data['email'],
                    'content' => $this->data['content'],
                ],
            ]);
    }
}
