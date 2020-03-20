<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 26-Sep-19
 * Time: 11:44 PM
 */

namespace src\Authorization;

class Request implements RequestInterface
{
    /** @var string|null */
    private $uri;

    /** @var string|null */
    private $method;

    /** @var string|null */
    private $host;

    /** @var string|null */
    private $port;

    /** @var string|null */
    private $scheme;

    /** @var array|null */
    private $jsonData;

    /**
     * Request constructor.
     * @param string|null $uri
     * @param string|null $method
     * @param string|null $host
     * @param string|null $port
     * @param string|null $scheme
     */
    public function __construct($uri = null, $method = null, $host = null, $port = null, $scheme = null)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->host = $host;
        $this->port = $port;
        $this->scheme = $scheme;
        $this->jsonData = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @return Request
     */
    public static function createFromGlobals(): Request
    {
        $currentRequest = new Request(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_SCHEME']
        );

        return $currentRequest;
    }

    public function identifier()
    {
        return substr($this->uri, strrpos($this->uri, '/') + 1);
    }

    public function all()
    {
        return array_merge($_GET, $_POST);
    }

    /**
     * @return string|null
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string|null
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string|null
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return string|null
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return array|null
     */
    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }
}