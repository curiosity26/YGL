<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 11:01 AM
 */

namespace YGL\Leads\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Leads\YGLLeadCollection;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLRequest;

class YGLLeadRequest extends YGLRequest {
    protected $property;
    protected $id;

    public function __construct($clientToken = FALSE, YGLProperty $property = NULL,
                                $id = NULL, ODataResourceInterface $query = NULL) {
        parent::__construct($clientToken, $query);
        if (isset($property)) {
            $this->setProperty($property);
        }
        $this->id($id);
    }

    public function id($id = NULL) {
        $this->id = $id;
        if (isset($this->property)) {
            $function = isset($id)
              ? 'properties/'.$this->property->id.'/leads/'.$id
              : 'properties/'.$this->property->id.'/leads';
            $this->setFunction($function);
        }
        return $this;
    }

    public function setProperty(YGLProperty $property) {
        $this->property = $property;
        $this->id($this->id); // Refresh the function
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function send() {
        $response = parent::send();
        if ($response->isSuccess()) {
            $property = $this->getProperty();
            // Response Code 201 means posted data was successfully added
            $body = $response->getResponseCode() != 201
              ? json_decode($response->getBody())
              : json_decode($response->getResponse()->getRawResponse());

            if (is_array($body)) {
                $leads = new YGLLeadCollection($this->getClient(), $body);
                $leads->rewind();
                $leads->setProperty($property);
                // Unlike properties, leads always returns a collection (for now)
                // To make this library behave in a constant fashion, the following line
                // will correct this behavior
                return $leads->count() > 1 ? $leads->rewind() : $leads->rewind()->current();
            }
            $lead = new YGLLead((array)$body, $this->getClient());
            $lead->setProperty($property);
            return $lead;
        }
        return $response;
    }
} 