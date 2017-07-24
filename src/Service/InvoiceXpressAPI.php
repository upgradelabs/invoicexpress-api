<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 21/07/2017
 * Time: 20:47
 */

namespace rpsimao\InvoiceXpressAPI\Service;

use GuzzleHttp\Client;
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
    public function setMethod(string $method)
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
    public function setUrl(string $url)
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
    public function setEndpoint(string $endpoint)
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
    public function setQuery(array $query) :void
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
     * @return StreamInterface
     */
    private function _get() :StreamInterface
    {
        $response = $this->client->get(
            $this->getUrl() . $this->getEndpoint(),
            [
                'query' => $this->getQuery()
            ]
        );

        return $response->getBody();
    }

    /**
     * Send POST request
     * @return StreamInterface
     */
    private function _post() :StreamInterface
    {

        $response = $this->client->post(
            $this->getUrl() . $this->getEndpoint(),
            [
                'headers' => ['Content-Type' => 'application/xml; charset=utf-8'],
                'query' => $this->getQuery()
            ]
        );

        return $response->getBody();
    }

    /**
     * Send PUT request
     * @return StreamInterface
     */
    private function _put() :StreamInterface
    {
        $response = $this->client->put(
            $this->getUrl() . $this->getEndpoint(),
            [
                'headers' => $this->getHeaders(),
                'query' => $this->getQuery()
            ]
        );

        return $response->getBody();
    }

    /**
     * Send DELETE request
     * @return StreamInterface
     */
    private function _delete() :StreamInterface
    {

    }
}