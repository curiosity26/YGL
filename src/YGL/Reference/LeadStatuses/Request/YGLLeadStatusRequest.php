<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 4/28/15
 * Time: 2:42 PM
 */

namespace YGL\Reference\LeadStatuses\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLLeadStatusRequest extends YGLReferenceRequest {

  protected $collectionClass = '\\YGL\\Reference\\LeadStatuses\\Collection\\YGLLeadStatusCollection';

  public function refreshFunction() {
    return $this->setFunction('leadstatuses');
  }
}