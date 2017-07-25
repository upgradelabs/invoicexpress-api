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

            case 'DELETE':
                return $this->_delete();
                break;
        }
    }

    /**
     * Send GET Request
     * @return string
     */
    private function _get(): string
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
            sleep(7);
            $request = new Request(strtoupper($this->getMethod()), $this->getUrl() . $this->getEndpoint());
            $response = $this->client->send($request, ['query' => $this->getQuery()]);

            return $response->getBody()->getContents();
        }


        return $response->getBody()->getContents();

    }

    /**
     * Send POST request
     * @return string
     */
    private function _post(): string
    {

        $response = $this->client->post(
            $this->getUrl() . $this->getEndpoint(),
            [
                'headers' => ['Content-Type' => 'application/xml; charset=utf-8'],
                'query' => $this->getQuery()
            ]
        );

        if ($response->getStatusCode() !== 200)
        {
            $this->_post();
        }

        return $response->getBody()->getContents();
    }

    /**
     * Send PUT request
     * @return string
     */
    private function _put(): string
    {
        $response = $this->client->put(
            $this->getUrl() . $this->getEndpoint(),
            [
                'headers' => $this->getHeaders(),
                'query' => $this->getQuery()
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * Send DELETE request
     * @return string
     */
    private function _delete(): string
    {

    }

	/**
	 * Pass to json
	 * @return string
	 */
    public function toJSON()
    {
    	return json_encode($this->talkToAPI());
    }
}