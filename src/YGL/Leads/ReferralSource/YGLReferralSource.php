<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\Leads\ReferralSource;


use YGL\YGLJsonObject;

class YGLReferralSource extends YGLJsonObject {

    public function __construct($values = NULL) {
        $this->_properties = array(
            'leadSourceId'      =>  self::integerProperty(),
            'leadSourceName'    =>  self::stringProperty(),
            'leadSourceRank'    =>  self::integerProperty()
        );

        parent::__construct((array)$values);
    }

    public function __get($name) {
        if ($name == 'id') {
            return $this->_properties['leadSourceId']['value'];
        }

        return parent::__get($name);
    }
} 