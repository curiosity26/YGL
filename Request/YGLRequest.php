<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:10 PM
 */

namespace YGL\Request;

use YGL\Request\HttpRequest;
use YGL\Response\YGLResponse;
use YGL\YGLClient;

class YGLRequest {
    private $client;
    private $headers = array();
    private $url = 'https://www.youvegotleads.com/api/';
    private $function;
    private $data;
    protected $limit = 500;
    protected $page = 0;
    protected $filter;

    public function __construct($clientToken = NULL) {
        if (isset($accessToken) && is_string($clientToken)) {
            // $clientToken is accessToken
            $this->client = new YGLClient($clientToken);
        }
        elseif (isset($clientToken) && $clientToken instanceof YGLClient) {
            $this->setClient($clientToken);
        }

        $this->headers['Host'] = isset($_SERVER['HTTP_HOST'])
          ? $_SERVER['HTTP_HOST'] : 'localhost';
        $this->headers['Accept'] = 'application/json';
        $this->headers['Content-Type'] = 'application/json';
    }

    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function setClient(YGLClient $client) {
        $this->client = $client;
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function setBody($data) {
        $this->data = json_encode($data);
        return $this;
    }

    public function setFunction($function) {
        $this->function = $function;
        return $this;
    }

    public function setLimit($limit = 500) {
        if ($limit <= 500) {
            $this->limit = $limit;
        }
        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setPage($page = 0) {
        $this->page = $page;
        return $this;
    }

    public function getPage() {
        return $this->page;
    }

    public function addFilter($field, $value = NULL, $op = NULL) {
        $value = isset($value) && is_string($value) ? "'{$value}'" : $value;
        $op = isset($op) ? "+{$op}+" : '';
        $this->filter = trim($field. $op . $value);
    }

    protected function build() {
        $url = $this->url.$this->function;

        if (!isset($this->data)) {
            $params = array(
                '$top' => $this->limit,
                '$skip' => $this->limit * $this->page
            );

            if (!empty($this->filter)) {
                $params['$filter'] = $this->filter;
            }

            $url .='?'.implode('&',$params);
        }

        return $url;
    }

    public function send() {
        $request = new \YGL\Request\HttpRequest(
            $this->build(),
            isset($this->data) ? HttpRequest::$METHOD_POST
              : HttpRequest::$METHOD_GET,
            $this->data,
            $this->headers
        );

        if (strlen($this->client->getUsername()) > 0) {
            $request->setHttpAuth(HttpRequest::$AUTH_BASIC,
              $this->client->getUsername(),
              $this->client->getPassword());
        }

        $response = $request->send();
        return new YGLResponse($response);
    }

    public function __set($name, $value) {
        if ($name == 'accessToken') {
            $this->accessToken = $value;
        }
    }
} 