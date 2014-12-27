<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 5:09 PM
 */

namespace YGL\Reference\ContactTimePreferences\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLContactTimePreferencesRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\ContactTimePreferences\YGLContactTimePreferenceCollection';

    public function refreshFunction() {
        $function = isset($this->id) ? 'contacttimepreferences/'.$this->id : 'contacttimepreferences';
        return $this->setFunction($function);
    }
}