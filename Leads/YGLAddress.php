<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 12:45 AM
 */

namespace YGL\Leads;


use YGL\YGLJsonObject;

class YGLAddress extends YGLJsonObject {

    public function __construct(array $values = NULL) {
        $this->_properties = array(
            'addressId'     =>  self::integerProperty(),
            'address1'      =>  self::stringProperty(),
            'address2'      =>  self::stringProperty(),
            'allowMailings' =>  self::booleanProperty(),
            'city'          =>  self::stringProperty(),
            'contactPreference' =>  self::integerProperty(),
            'contactTimePref'   =>  self::integerProperty(),
            'country'       =>  self::stringProperty(2),
            'email'         =>  self::stringProperty(255),
            'fax'           =>  self::stringProperty(18),
            'phoneCell'     =>  self::stringProperty(18),
            'phoneHome'     =>  self::stringProperty(18),
            'phoneWork'     =>  self::stringProperty(18),
            'state'         =>  self::stringProperty(2),
            'updatedOn'     =>  self::datetimeProperty(),
            'zip'           =>  self::stringProperty(10)
        );

        parent::__construct($values);
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['addressId']['value'];
        }

        return parent::__get($name);
    }
} 