<?php

use PHPUnit\Framework\TestCase;
use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;

class GetTest extends TestCase {

	/**
	 * Use your own credentials to run the tests
	 */
	protected $url      = '';
	protected $api_key  = '';


	public function setUp()
	{
		parent::setUp();
	}

	public function testCanMakeGetRequest()
	{
		$endpoint = 'clients.xml';

		$client = new InvoiceXpressAPI();
		$client->setMethod('GET');
		$client->setUrl($this->url);
		$client->setEndpoint($endpoint);
		$client->setQuery(['api_key' => $this->api_key]);
		$client->talkToAPI();
		$data = $client->toJSON();

		$this->assertJson($data);
	}

	public function testCanMakePutRequest()
	{
		$endpoint = 'clients/{client-id}.xml';

		$client = new InvoiceXpressAPI();
		$client->setMethod('put');
		$client->setUrl($this->url);
		$client->setEndpoint($endpoint);
		$client->setQuery([
			'api_key' => $this->api_key,
			'client-id' => '',
			'client' => [
				'name' => '',
				'code' => '',
				'phone' =>  ''

			]
		]);
		$client->talkToAPI();
		$data = $client->toJSON();

		$this->assertJson($data);

	}

	public function testGetAPIKey()
	{
		$client = new InvoiceXpressAPI();
		$api_key = $client->getAPIKey( '', '');

		$this->assertEquals($this->api_key, $api_key);
	}

}