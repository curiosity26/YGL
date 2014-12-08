<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\Leads;


use YGL\YGLJsonObject;

class YGLReferralSource extends YGLJsonObject {

    public function __construct(array $values = NULL) {
        $this->_properties = array(
            'leadSourceId'      =>  self::integerProperty(),
            'leadSourceName'    =>  self::stringProperty(),
            'leadSourceRank'    =>  self::integerProperty()
        );

        parent::__construct($values);
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['leadSourceId']['value'];
        }

        return parent::__get($name);
    }
} 