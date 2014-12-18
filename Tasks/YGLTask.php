<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 10:05 PM
 */

namespace YGL\Tasks;


use YGL\YGLJsonObject;

class YGLTask extends YGLJsonObject {
  public function __construct(array $values = NULL) {

    $this->_properties = array(
      'taskId'        => self::integerProperty(),
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
      'owderId'         => self::integerProperty(),
      'ownderUsername'  => self::stringProperty(10)
    );

    parent::__construct($values = NULL);
  }

  public function __get($name) {
    if ($name == 'id') {
      return $this->_properties['taskId']['value'];
    }

    return parent::__get($name);
  }
} 