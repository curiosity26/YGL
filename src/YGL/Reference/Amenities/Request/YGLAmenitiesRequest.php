<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 3:10 PM
 */

namespace YGL\Reference\Amenities\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLAmenitiesRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\Amenities\Collection\YGLAmenitiesCollection';

    public function refreshFunction() {
        $function = isset($this->id) ? 'amentities/'.$this->id : 'amenities';
        return $this->setFunction($function);
    }
}