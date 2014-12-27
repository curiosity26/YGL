<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:38 PM
 */

namespace YGL\Reference\TaskTypes\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLTaskTypesRequest extends  YGLReferenceRequest {
    protected $collectionClass = '\YGL\Reference\TaskTypes\Collection\YGLTaskTypeCollection';

    public function refreshFunction() {
        $function = isset($this->id) ? 'tasktypes/'.$this->id : 'tasktypes';
        return $this->setFunction($function);
    }
}