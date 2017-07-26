<?php
/**
 * invoicexpress-api
 *
 * rpsimao
 * 25/07/2017
 */

use PHPUnit\Framework\TestCase;
use rpsimao\InvoiceXpressAPI\Service\InvoiceXpressAPI;

class GetTest extends TestCase {

	/**
	 * Use your own credentials to run the tests
	 */
	protected $url          = '';
	protected $api_key      = '';
	protected $username     = '';
	protected $password     = '';
	protected $client_id    = '';
	protected $client_name  = '';
	protected $client_code  = '';
	protected $client_phone = '';
	protected $invoice      = '';


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

		$err = json_decode($data);

		if (isset( $err->code))
		{
			$this->fail('Message: ' . $err->message . PHP_EOL . ' File: ' . $err->file . PHP_EOL . ' Line: '. $err->line);
		} else {
			$this->assertJson( $data);
		}
	}

	public function testCanMakePutRequest()
	{
		$endpoint = 'clients/'.$this->client_id.'.xml';

		$client = new InvoiceXpressAPI();
		$client->setMethod('put');
		$client->setUrl($this->url);
		$client->setEndpoint($endpoint);
		$client->setQuery([
			'api_key' => $this->api_key,
			'client-id' => $this->client_id,
			'client' => [
				'name' => $this->client_name,
				'code' => $this->client_code,
				'phone' =>  $this->client_phone
			]
		]);
		$client->talkToAPI();
		$data = $client->toJSON();
		$err = json_decode($data);

		if (isset( $err->code))
		{
			$this->fail('Message: ' . $err->message . PHP_EOL . ' File: ' . $err->file . PHP_EOL . ' Line: '. $err->line);
		} else {
			$this->assertJson( $data);
		}

	}

	public function testGetAPIKey()
	{
		$client = new InvoiceXpressAPI();
		$api_key = $client->getAPIKey( $this->username, $this->password);

		$this->assertEquals($this->api_key, $api_key);
	}

	public function testCanGeneratePDFInvoice()
	{
		$endpoint = 'api/pdf/'.$this->invoice.'.xml';

		$client = new InvoiceXpressAPI();
		$client->setMethod('get');
		$client->setUrl($this->url);
		$client->setEndpoint($endpoint);
		$client->setQuery([
			'api_key' => $this->api_key,
			'invoice-id' => $this->invoice
		]);
		$client->talkToAPI();
		$data = $client->toJSON();
		$err = json_decode($data);

		if (isset( $err->code))
		{
			$this->fail('Message: ' . $err->message . PHP_EOL . ' File: ' . $err->file . PHP_EOL . ' Line: '. $err->line);
		} else {
			$this->assertJson( $data);
		}
	}

}