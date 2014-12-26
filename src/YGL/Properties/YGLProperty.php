<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:37 PM
 */

namespace YGL\Properties;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Leads\YGLLeadCollection;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLProperty extends YGLJsonObject {

    public function __construct($values = NULL, YGLClient $client = NULL) {

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

        parent::__construct((array)$values, $client);
    }

    public function getLeads($id = NULL, ODataResourceInterface $query = NULL) {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getLeads($this, $id, $query);
        }
        return FALSE;
    }

    public function addLead(YGLLead $lead) {
        $lead->setProperty($this);
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->addLead($this, $lead);
        }
        return NULL;
    }

    public function addLeads(YGLLeadCollection $leads) {
        $leads->setProperty($this);
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->addLeads($this, $leads);
        }
        return NULL;
    }

    public function getTasks(ODataResourceInterface $query = NULL) {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getTasks($this, $query);
        }
        return FALSE;
    }

    public function getUsers($id = NULL, ODataResourceInterface $query = NULL) {
        if (($client = $this->getClient()) && $client instanceof YGLClient) {
            return $client->getUsers($this, $id, $query);
        }
        return FALSE;
    }

    public function __get($name) {
        if ($name == 'id') {
            return parent::__get('propertyId');
        }

        return parent::__get($name);
    }
} 