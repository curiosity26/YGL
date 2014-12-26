<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 10:07 PM
 */

namespace YGL\Users;


use YGL\Properties\YGLProperty;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLUser extends YGLJsonObject {
    protected $property;

    public function __construct(array $values = NULL, YGLClient $client = NULL) {

        $this->_properties = array(
            'userName'  => self::stringProperty(255),
            'firstName' => self::stringProperty(255),
            'lastName'  => self::stringProperty(255),
            'role'      => self::stringProperty(255),
            'usersId'   => self::integerProperty()
        );
        parent::__construct($values, $client);
    }

    public function setProperty(YGLProperty $property) {
        $this->property = $property;
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function __get($name) {
        if ($name == 'id') {
            return parent::__get('usersId');
        }
        return parent::__get($name);
    }

} 