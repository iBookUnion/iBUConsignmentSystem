<?php


require('vendor/autoload.php');

class UsersTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_url' => 'https://ibu-rcacho.c9.io/iBUConsignmentSitePrototype/ibu_test/v1/',
            'defaults' => ['exceptions' => false]
        ]);
    }

    public function testGet_ValidInput_UserObject()
    {
        $response = $this->client->get('https://ibu-rcacho.c9.io/iBUConsignmentSitePrototype/ibu_test/v1/users/1');

        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->json();

        $this->assertArrayHasKey('student_id', $data);
        $this->assertArrayHasKey('first_name', $data);
        $this->assertArrayHasKey('last_name', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('phone_number', $data);
    }
}