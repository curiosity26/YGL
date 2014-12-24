<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:49 PM
 */

namespace YGL\Leads;


use YGL\Properties\YGLProperty;
use YGL\Tasks\YGLTask;
use YGL\Tasks\YGLTaskCollection;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLLead extends YGLJsonObject {
    protected $client;
    protected $property;

    public function __construct($values = NULL, YGLClient $client = NULL) {
        if (isset($client)) {
            $this->setClient($client);
        }

        $this->_properties = array(
            'leadId'            =>  self::integerProperty(),
            'contactId'         =>  self::integerProperty(),
            'secondaryContactId'=>  self::integerProperty(),
            'addedOn'           =>  self::datetimeProperty(),
            'associate'         =>  self::stringProperty(45),
            'budgetMin'         =>  self::integerProperty(),
            'budgetMax'         =>  self::integerProperty(),
            'callCenterId'      =>  self::stringProperty(),
            'createdOn'         =>  self::datetimeProperty(),
            'dischargePlannerId'=>  self::integerProperty(),
            'familyStatusId'    =>  self::integerProperty(),
            'fundingType'       =>  self::integerProperty(),
            'inquiryMethod'     =>  self::stringProperty(30),
            'leadResident'      =>  self::residentProperty(),
            'notes'             =>  self::notesProperty(),
            'ownership'         =>  self::stringProperty(1),
            'primaryContact'    =>  self::contactProperty(),
            'priority'          =>  self::integerProperty(),
            'referralSources'   =>  self::referralSourceCollectionProperty(),
            'residentContact'   =>  self::contactProperty(),
            'secondaryContact'  =>  self::contactProperty(),
            'secondFundingType' =>  self::integerProperty(),
            'userName'          =>  self::stringProperty(10),
            'veteran'           =>  self::stringProperty(1)
        );

        parent::__construct((array)$values);
    }

    public function setClient(YGLClient $client) {
        $this->client = $client;
        if (isset($this->property)) {
            $this->property->setClient($client);
        }
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function setProperty(YGLProperty $property) {
        $this->property = NULL;
        if (isset($this->client)) {
            $property->setClient($this->client);
        }
        elseif ($client = $property->getClient()) {
            $this->setClient($client);
        }
        $this->property = $property;
    }

    public function getProperty() {
        return $this->property;
    }

    public function addTask(YGLTask $task) {
        $task->setLead($this);
        if (isset($this->client) && isset($this->property)) {
            return $this->getClient()->addTask($this->getProperty(), $this, $task);
        }
        return FALSE;
    }

    public function addTasks(YGLTaskCollection $tasks) {
        $tasks->setLead($this);
        if (isset($this->client) && isset($this->property)) {
            return $this->getClient()->addTasks($this->getProperty(), $this, $tasks);
        }
        return FALSE;
    }

    public function getTasks($id = NULL) {
        if (isset($this->client) && isset($this->property)) {
            return $this->getClient()->getTasks($this->getProperty(), $this, $id);
        }
        return NULL;
    }


    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['leadId']['value'];
        }
        elseif ($name == 'client') {
            return $this->getClient();
        }

        return parent::__get($name);
    }

    public function __set($name, $value) {
        if ($name == 'client') {
            if ($value instanceof YGLClient) {
                $this->setClient($value);
            }
        }
        else {
            parent::__set($name, $value);
        }
    }
} 