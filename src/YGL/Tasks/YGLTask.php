<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 10:05 PM
 */

namespace YGL\Tasks;


use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLTask extends YGLJsonObject {
  protected $client;
  protected $property;
  protected $lead;

  public function __construct($values = NULL) {

    $this->_properties = array(
      'taskId'        => self::integerProperty(),
      'propertyId'    => self::integerProperty(),
      'leadId'        => self::integerProperty(),
      'contactId'     => self::integerProperty(),
      'priorityId'    => self::integerProperty(),
      'followupDate'  => self::datetimeProperty(),
      'taskTitle'     => self::stringProperty(35),
      'status'        => self::booleanProperty(),
      'taskTypeId'    => self::integerProperty(),
      'taskType'      => self::stringProperty(),
      'createdOn'     => self::datetimeProperty(),
      'createdBy'     => self::stringProperty(10),
      'childTaskTypeId' => self::integerProperty(),
      'childTaskType'   => self::stringProperty(),
      'isGroupTask'     => self::booleanProperty(),
      'completedDate'   => self::datetimeProperty(),
      'madeContactMode' => self::stringProperty(),
      'updatedOn'       => self::datetimeProperty(),
      'updatedBy'       => self::stringProperty(10),
      'isAllDay'        => self::booleanProperty(),
      'duration'        => self::integerProperty(),
      'timeZoneId'      => self::stringProperty(32),
      'ownerId'         => self::integerProperty(),
      'ownderUsername'  => self::stringProperty(10)
    );

    parent::__construct((array)$values);
  }

  public function setClient(YGLClient $client) {
    $this->client = $client;
    if (isset($this->property)) {
      $this->property->setClient($client);
    }
    if (isset($this->lead)) {
      $this->lead->setClient($client);
    }
    return $this;
  }

  public function getClient() {
    return $this->client;
  }

  public function setProperty(YGLProperty $property) {
    $this->property = NULL;
    // All items should share the same client
    if (isset($this->client)) {
      $property->setClient($this->client);
    }
    elseif ($client = $property->getClient()) {
      $this->setClient($client);
    }
    $this->property = $property;
    $this->propertyId = $property->id;
    return $this;
  }

  public function getProperty() {
    return $this->property;
  }

  public function setLead(YGLLead $lead) {
    $this->lead = NULL;
    // All items should share the same client
    if (isset($this->client)) {
      $lead->setClient($this->client);
    }
    elseif ($client = $lead->getClient()) {
      $this->setClient($client);
    }

    if ($property = $lead->getProperty()) {
      // It's more important the Task gets the same property as the lead
      $this->setProperty($property);
    }
    $this->lead = $lead;
    $this->leadId = $lead->id;
    return $this;
  }

  public function getLead() {
    return $this->lead;
  }

  public function __get($name) {
    if ($name == 'id') {
      return $this->_properties['taskId']['value'];
    }

    return parent::__get($name);
  }
} 