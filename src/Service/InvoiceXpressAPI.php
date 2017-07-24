<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 21/07/2017
 * Time: 20:47
 */

namespace rpsimao\Service;

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
    protected $headers = 'Content-Type: application/xml; charset=utf-8';

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
     * @return string
     */
    private function getHeaders(): string
    {
        return $this->headers;
    }

    /**
     * @param string $headers
     */
    public function setHeaders(string $headers)
    {
        $this->headers = $headers;
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
     * @return \Psr\Http\Message\StreamInterface
     */
    public function talkToAPI() :StreamInterface
    {
        $response = $this->client->request(
            $this->getMethod(), $this->getUrl() . $this->getEndpoint(),
            [
                'query' => $this->getQuery()
            ]
        );

        return $response->getBody();
    }
}