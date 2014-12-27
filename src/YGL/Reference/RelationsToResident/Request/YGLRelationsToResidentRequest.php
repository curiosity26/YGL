<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 8:33 PM
 */

namespace YGL\Reference\RelationsToResident\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLRelationsToResidentRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\RelationsToResident\Collection\YGLRelationToResidentCollection';

    public function refreshFunction() {
        $function = isset($this->id) ? 'relationstoresident/'.$this->id : 'relationstoresident';
        return $this->setFunction($function);
    }
}