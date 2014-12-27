<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 6:20 PM
 */

namespace YGL\Reference\CurrentLivingSituations\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLCurrentLivingSituationsRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\CurrentLivingSituations\YGLCurrentLivingSituation';

    public function refreshFunction() {
        $function = isset($this->id) ? 'currentlivingsituations/'.$this->id : 'currentlivingsituations';
        return $this->setFunction($function);
    }
}