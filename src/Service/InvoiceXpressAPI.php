<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 21/07/2017
 * Time: 20:47
 */

namespace rpsimao\InvoiceXpressAPI\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\StreamInterface;

/**
 * Class InvoiceXpressAPI
 * @package rpsimao\Service
 */

class InvoiceXpressAPI
{

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * Defines the http method GET|POST|PUT|DELETE
	 * @var string
	 */
	protected $method;

	/**
	 * The API url
	 * @var string
	 */
	protected $url;

	/**
	 * The endpoint of the API url
	 * @var string
	 */
	protected $endpoint;

	/**
	 * Header to be sent to the POST|PUT REQUEST API
	 * @var string
	 */
	protected $headers;

	/**
	 * The query to send to the API
	 * @var array
	 */
	protected $query = [];

	/**
	 * InvoiceXpressAPI constructor.
	 * Initialize GuzzleHttp\Client
	 */
	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * @return string
	 */
	private function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @param string $method
	 */
	public function setMethod(string $method): void
	{
		$this->method = $method;
	}


	/**
	 * @return array
	 */
	private function getHeaders(): array
	{
		return ['Content-Type' => 'application/xml; charset=utf-8'];
	}

	/**
	 * @return string
	 */
	private function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl(string $url): void
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	private function getEndpoint(): string
	{
		return $this->endpoint;
	}

	/**
	 * @param string $endpoint
	 */
	public function setEndpoint(string $endpoint): void
	{
		$this->endpoint = $endpoint;
	}

	/**
	 * @return array
	 */
	private function getQuery(): array
	{
		return $this->query;
	}

	/**
	 * @param array $query
	 */
	public function setQuery(array $query): void
	{
		$this->query = $query;
	}

	/**
	 * Send requests to InvoiceXpress API
	 *
	 */
	public function talkToAPI()
	{
		switch (strtoupper($this->getMethod())){
			case 'GET':
				return $this->_get();
				break;

			case 'POST':
				return $this->_post();
				break;

			case 'PUT':
				return $this->_put();
				break;
		}
	}

	/**
	 * Send GET Request
	 * @return StreamInterface
	 */
	private function _get(): StreamInterface
	{
		$response = $this->client->get(
			$this->getUrl() . $this->getEndpoint(),
			[
				'query' => $this->getQuery()
			]
		);

		/**
		 * If a 202 header is returned the request will be processed.
		 * You need to keep requesting until you get a response with HTTP status code 200.
		 * It sleeps for 7 seconds, for that to happen
		 * @see https://invoicexpress.com/api/invoices/documents-pdf
		 */

		if ($response->getStatusCode() === 202)
		{
			sleep(6);
			$request = new Request(strtoupper($this->getMethod()), $this->getUrl() . $this->getEndpoint());
			$response = $this->client->send($request, ['query' => $this->getQuery()]);

			return $response->getBody();
		}

		return $response->getBody();

	}

	/**
	 * Send POST request
	 * @return StreamInterface
	 */
	private function _post(): StreamInterface
	{
		$response = $this->client->post(
			$this->getUrl() . $this->getEndpoint(),
			[
				'headers' => $this->getHeaders(),
				'query' => $this->getQuery()
			]
		);

		return $response->getBody();
	}

	/**
	 * Send PUT request
	 *
	 */
	private function _put()
	{
		$response = $this->client->put(
			$this->getUrl() . $this->getEndpoint(),
			[
				'headers' => $this->getHeaders(),
				'query' => $this->getQuery()
			]
		);

		$responses = [200, 201];
		if (in_array( $response->getStatusCode(),  $responses, true))
		{
			return [
				'header' => $response->getStatusCode(),
				'message' => 'CREATED'
			];
		}

		return $response->getBody();
	}

	/**
	 * Returns values as JSON
	 *
	 */
	public function toJSON()
	{
		if (is_array(  $this->talkToAPI()))
		{
			return json_encode($this->talkToAPI());
		}

		$xml = simplexml_load_string($this->talkToAPI(), 'SimpleXMLElement', LIBXML_NOCDATA);
		return json_encode($xml);
	}

	/**
	 * Return values as a XML
	 *
	 */
	public function toXML()
	{
		if (is_array(  $this->talkToAPI()))
		{
			$xml_data = new \SimpleXMLElement('<?xml version="1.0"?><response></response>');
			$data = $this->talkToAPI();
			$this->array_to_xml($data, $xml_data);
			return  $xml_data->asXML();
		}

		return simplexml_load_string( $this->talkToAPI());
	}

	private function array_to_xml( array $data, \SimpleXMLElement $xml_data ) {
		foreach( $data as $key => $value ) {
			if( is_numeric($key) ){
				$key = 'item'.$key; //dealing with <0/>..<n/> issues
			}
			if( is_array($value) ) {
				$subnode = $xml_data->addChild($key);
				$this->array_to_xml($value, $subnode);
			} else {
				$xml_data->addChild("$key",htmlspecialchars("$value"));
			}
		}
	}
}