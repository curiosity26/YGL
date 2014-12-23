<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:37 PM
 */

namespace YGL\Properties;


use YGL\Leads\YGLLead;
use YGL\Leads\YGLLeadCollection;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLProperty extends YGLJsonObject {
    protected $client;

    public function __construct(array $values = NULL, YGLClient $client = NULL) {
        if (isset($client)) {
            $this->setClient($client);
        }

        $this->_properties = array(
            'propertyId'    =>  self::integerProperty(),
            'name'          =>  self::stringProperty(255),
            'address1'      =>  self::stringProperty(),
            'address2'      =>  self::stringProperty(),
            'city'          =>  self::stringProperty(255),
            'region'        =>  self::stringProperty(40),
            'state'         =>  self::stringProperty(10),
            'zip'           =>  self::stringProperty(30),
            'division'      =>  self::stringProperty(40),
            'country'       =>  self::stringProperty(2),
            'updatedBy'     =>  self::stringProperty(10),
            'updatedOn'     =>  self::datetimeProperty()
        );

        parent::__construct($values);
    }

    public function setClient(YGLClient $client) {
        $this->client = $client;
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function getLeads($id = NULL) {
        if ($this->client instanceof YGLClient) {
            return $this->client->getLeads($this, $id);
        }
        return FALSE;
    }

    public function addLead(YGLLead $lead) {
        if ($this->client instanceof YGLClient) {
            $this->client->addLead($this, $lead);
        }
        return $this;
    }

    public function addLeads(YGLLeadCollection $leads) {
        if ($this->client instanceof YGLClient) {
            $this->client->addLeads($this, $leads);
        }
        return $this;
    }

    public function getTasks() {
        if ($this->client instanceof YGLClient) {
            return $this->client->getTasks($this);
        }
        return FALSE;
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['propertyId']['value'];
        }
        elseif ($name == 'leads') {
            return $this->getLeads();
        }
        elseif ($name == 'client') {
            return $this->getClient();
        }

        return parent::__get($name);
    }

    public function __set($name, $value) {
        if ($name == 'leads') {
            if ($value instanceof YGLLead) {
                $this->addLead($value);
            }
            elseif (is_array($value)) {
                $collection = new YGLLeadCollection($value);
                $this->addLeads($collection);
            }
            elseif ($value instanceof YGLLeadCollection) {
                $this->addLeads($value);
            }
        }
        elseif ($name == 'client' && $value instanceof YGLClient) {
            $this->setClient($value);
        }
        else {
            parent::__set($name, $value);
        }
    }
} 