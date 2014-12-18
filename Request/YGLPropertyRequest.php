<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 11:27 PM
 */

namespace YGL\Request;

use YGL\Properties\YGLPropertyCollection;

class YGLPropertyRequest extends YGLRequest {
    protected $limit = 20;

    public function __construct($clientToken = NULL, $id = NULL) {
        parent::__construct($clientToken);
        $this->id($id);
    }

    public function id($id = NULL) {
        $this->setFunction(isset($id) ? 'properties/'.$id : 'properties');
        return $this;
    }

    public function setLimit($limit = 20) {
        if ($limit <= 20) {
            parent::setLimit($limit);
        }

        return $this;
    }

    public function send() {
        $properties = new YGLPropertyCollection();
        $response = parent::send();
        if ($response->isSuccess()) {
            $properties->collection = json_decode($response->getBody());
        }

        return $properties;
    }
} 