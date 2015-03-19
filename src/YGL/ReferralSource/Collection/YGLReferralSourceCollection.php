<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\ReferralSource\Collection;


use YGL\Collection\YGLCollection;
use YGL\YGLClient;

class YGLReferralSourceCollection extends YGLCollection {
  protected $itemValue = 'YGL\ReferralSource\YGLReferralSource';

  public function __construct() {
    $args = func_get_args();

    if (is_array($args[0])) {
      $client = isset($args[1]) && $args[1] instanceof YGLClient ? $args[1] : null;
      parent::__construct($client, $args[0]);
    }
    else {
      $client = isset($args[0]) && $args[0] instanceof YGLClient ? $args[0] : null;
      $values = isset($args[1]) && is_array($args[1]) ? $args[1] : array();
      parent::__construct($client, $values);
    }
  }
} 