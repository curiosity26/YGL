<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 2:26 PM
 */

namespace YGL\Request;

use YGL\Response\HttpResponse;

class HttpRequest {
    protected $ch;
    protected $url;
    protected $port;
    protected $method;
    protected $headers = array();
    protected $body;
    protected $cookie;
    protected $maxRedirects = 10;
    protected $timeout = 10;
    protected $authMethod;
    protected $authCredentials;

    /* Method Constants */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_HEAD = 'HEAD';
    const METHOD_CONNECT = 'CONNECT';

    /* Authorization Constants */
    const AUTH_ANY = CURLAUTH_ANY;
    const AUTH_ANYSAFE = CURLAUTH_ANYSAFE;
    const AUTH_BASIC = CURLAUTH_BASIC;
    const AUTH_DIGEST = CURLAUTH_DIGEST;
    const AUTH_NTLM = CURLAUTH_NTLM;
    const AUTH_GSSNEGOTIATE = CURLAUTH_GSSNEGOTIATE;


    public function __construct($url = NULL, $method = 'GET', $data = NULL, array $headers = NULL, $port = NULL) {

        if (isset($url)) {
            $this->setUrl($url);
        }

        $this->setMethod($method);
        $this->cookie = tempnam('/tmp', "CURLCOOKIE");

        if (isset($data)) {
            $this->setBody($data);
        }

        if (isset($headers)) {
            $this->setHeaders($headers);
        }

        if (isset($port)) {
            $this->setPort($port);
        }
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setMethod($method) {

        if (in_array($method, array())) {
            $this->method = $method;
        }

        return $this;
    }

    public function setPort($port) {
        $this->port = $port;
        return $this;
    }

    public function getPort() {
        return $this->port;
    }

    protected function buildHeaders() {
        $headers = array();
        foreach ($this->headers as $name => $value) {
            $headers[] = $name.': '.$value;
        }
        return $headers;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    public function removeHeader($name) {
        unset($this->headers[$name]);
        return $this;
    }

    public function setHeaders(array $headers) {
        $this->headers = $headers;
        return $this;
    }

    public function setCookie($cookie) {
        $this->cookie = $cookie;
        return $this;
    }

    public function getCookie() {
        return $this->cookie;
    }

    public function setHttpAuth($authType, $usermame, $password) {
        if (in_array($authType, array(
                self::AUTH_ANY,
                self::AUTH_ANYSAFE,
                self::AUTH_BASIC,
                self::AUTH_DIGEST,
                self::AUTH_NTLM,
                self::AUTH_GSSNEGOTIATE
            ))) {
            $this->authMethod = $authType;
            $this->authCredentials = $usermame.':'.$password;
        }
    }

    public function setBody($data) {
        $this->body = $data;
        return $this;
    }

    public function getBody() {
        return $this->body;
    }

    protected function build() {
        curl_setopt_array($this->ch, array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_VERBOSE => TRUE,
                CURLOPT_COOKIEJAR => $this->cookie,
                CURLOPT_PORT => isset($this->port) ? $this->port : 80,
                CURLOPT_FAILONERROR => FALSE,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_MAXREDIRS => $this->maxRedirects,
                CURLOPT_AUTOREFERER => TRUE,
                CURLINFO_HEADER_OUT => TRUE,
                CURLOPT_HEADER => $this->buildHeaders()
            ));

        if (preg_match('/^https:/', $this->url) !== FALSE) {
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            if (!isset($this->port)) {
                $this->port = 443;
                curl_setopt($this->ch, CURLOPT_PORT, $this->port);
            }
        }


        if (is_string($this->cookie)) {
            curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
        }
        else if (is_resource($this->cookie) && get_resource_type($this->cookie) == 'file') {
            curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie);
        }

        switch ($this->method) {
            case self::METHOD_POST:
                curl_setopt($this->ch, CURLOPT_POST, TRUE);
                break;
            case self::METHOD_PUT:;
                curl_setopt($this->ch, CURLOPT_PUT, TRUE);
                break;
            case self::METHOD_HEAD:
            case self::METHOD_DELETE:
            case self::METHOD_CONNECT:
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $this->method);
                break;
            default:
                curl_setopt($this->ch, CURLOPT_HTTPGET, TRUE);
        }

        if ($this->method == self::METHOD_PUT && get_resource_type($this->body) == 'file') {
            curl_setopt($this->ch, CURLOPT_INFILE, $this->body);
        }
        elseif (is_string($this->body) || is_array($this->body)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->body);
        }

        if (isset($this->authMethod)) {
            curl_setopt($this->ch, CURLOPT_HTTPAUTH, $this->authMethod);
            curl_setopt($this->ch, CURLOPT_USERPWD, $this->authCredentials);
        }

        return $this;
    }

    public function send() {
        $this->ch = curl_init();
        $this->build();
        $body = curl_exec($this->ch);
        $response = curl_getinfo($this->ch);
        curl_close($this->ch);

        return new HttpResponse($body, $response);
    }
} 