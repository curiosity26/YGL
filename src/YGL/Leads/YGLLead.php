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
        if (($client = $this->getClient()) && $client instanceof YGLClient && ($property = $this->getProperty()) &&
            $property instanceof YGLProperty) {
            return $client->addTask($property, $this, $task);
        }
        return FALSE;
    }

    public function addTasks(YGLTaskCollection $tasks) {
        $tasks->setLead($this);
        if (($client = $this->getClient()) && $client instanceof YGLClient && ($property = $this->getProperty()) &&
            $property instanceof YGLProperty) {
            return $client->addTasks($property, $this, $tasks);
        }
        return FALSE;
    }

    public function getTasks($id = NULL) {
        if (($client = $this->getClient()) && $client instanceof YGLClient && ($property = $this->getProperty()) &&
            $property instanceof YGLProperty) {
            return $client->getTasks($property, $this, $id);
        }
        return NULL;
    }


    public function __get($name) {
        if ($name == 'id') {
            return parent::__get('leadId');
        }

        return parent::__get($name);
    }
} 