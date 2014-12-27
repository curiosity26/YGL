<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 4:41 PM
 */

namespace YGL\Reference\ContactPreferences\Request;


use YGL\Reference\YGLReferenceRequest;

class YGLContactPreferencesRequest extends YGLReferenceRequest {
    protected $collectionClass = 'YGL\Reference\ContactPreferences\YGLContactPreference';

    public function refreshFunction() {
        $function = isset($this->id) ? 'contactpreferences/'.$this->id : 'contactpreferences';
        return $this->setFunction($function);
    }
}