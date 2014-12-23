<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 11:01 AM
 */

namespace YGL\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLeadCollection;
use YGL\Properties\YGLProperty;

class YGLLeadRequest extends YGLRequest {
    protected $property;
    protected $id;

    public function __construct($clientToken = FALSE, YGLProperty $property = NULL,
                                $id = NULL, ODataResourceInterface $query) {
        parent::__construct($clientToken, $query);
        if (isset($property)) {
            $this->setProperty($property);
            $this->id($id);
        }
    }

    public function id($id = NULL) {
        $this->id = $id;
        $function = isset($id) ? 'properties/'.$this->property->id.'/leads/'.$id
            : 'properties/'.$this->property->id.'/leads';
        $this->setFunction($function);
        return $this;
    }

    public function setProperty(YGLProperty $property) {
        $this->property = $property;
        $this->id($this->id);
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function send() {
        $response = parent::send();
        $leads = new YGLLeadCollection();
        if ($response->isSuccess()) {
            $leads->collection = json_decode($response->getBody(), TRUE);
        }
        return $leads;
    }
} 