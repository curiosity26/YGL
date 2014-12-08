<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:37 PM
 */

namespace YGL\Properties;


use YGL\YGLJsonObject;

class YGLProperty extends YGLJsonObject {

    public function __construct(array $values = NULL) {
        $this->_properties = array(
            'propertyId'    =>  self::integerProperty(),
            'name'          =>  self::stringProperty(255),
            'address1'      =>  self::stringProperty(),
            'address2'      =>  self::stringProperty(),
            'city'          =>  self::stringProperty(255),
            'region'        =>  self::stringProperty(40),
            'state'         =>  self::stringProperty(10),
            'zip'           =>  self::stringProperty(30),
            'division'      =>  self::stringProperty(40),
            'country'       =>  self::stringProperty(2),
            'updatedBy'     =>  self::stringProperty(10),
            'updatedOn'     =>  self::datetimeProperty()
        );

        parent::__construct($values);
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['propertyId']['value'];
        }

        return parent::__get($name);
    }
} 