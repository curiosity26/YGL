<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 10:49 AM
 */

namespace YGL\Users\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLRequest;
use YGL\Users\YGLUser;
use YGL\Users\YGLUsersCollection;

class YGLUserRequest extends YGLRequest {
    protected $property;
    protected $id;

    public function __construct($clientToken = FALSE, YGLProperty $property = NULL, $id = NULL,
        ODataResourceInterface $query = NULL) {
        parent::__construct($clientToken, $query);
        if (isset($property)) {
            $this->setProperty($property);
            $this->id($id);
        }
    }

    public function setProperty(YGLProperty $property) {
        $this->property = $property;
        $this->id($this->id); // Refresh the function
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function id($id = NULL) {
        $this->id = $id;
        if ($property = $this->getProperty()) {
            $function = 'properties/'.$property->id.'/users';
            if (isset($id)) {
                $function .= '/'.$id;
            }
            $this->setFunction($function);
        }
        return $this;
    }

    public function send() {
        $response = parent::send();
        if ($response->isSuccess()) {
            $body = $response->getResponseCode() != 201
                ? json_decode($response->getBody())
                : json_decode($response->getResponse()->getRawResponse());
            if (is_array($body)) {
                $users = new YGLUsersCollection($this->getClient(), $body);
                if (isset($this->property)) {
                    $users->setProperty($this->getProperty());
                }
                return $users->count() > 1 ? $users->rewind() : $users->rewind()->current();
            }
            else {
                return new YGLUser((array)$body, $this->getClient());
            }
        }
        return $response;

    }
}