<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 4/28/15
 * Time: 2:42 PM
 */

namespace YGL\Reference\LeadStatuses;


use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLLeadStatus extends YGLJsonObject {

  protected $uniqueId = 'statusId';

  public function __construct(array $values = array(), YGLClient $client = NULL) {
    $this->_properties = array(
      'statusId' => self::integerProperty(),
      'statusName' => self::stringProperty(),
      'closedFlag' => self::integerProperty(0),
      'closedFlagDescription' => self::stringProperty(7),
      'industryId' => self::integerProperty(),
      'subscriptionId' => self::integerProperty(0)
    );

    parent::__construct($values, $client);
  }
}