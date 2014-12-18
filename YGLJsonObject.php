<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 12:16 AM
 */

namespace YGL;

use YGL\Leads\YGLAddress;
use YGL\Leads\YGLContact;
use YGL\Leads\YGLLead;
use YGL\Leads\YGLLeadNotes;
use YGL\Leads\YGLLeadResident;
use YGL\Leads\YGLReferralSourceCollection;
use YGL\Properties\YGLProperty;
use YGL\Tasks\YGLTask;
use YGL\Users\YGLUser;

class YGLJsonObject implements \JsonSerializable {
    protected $_properties = array();

    public function __construct(array $values = NULL) {
        if (isset($values)) {
            foreach ($values as $key => $value) {
                $this->__set($key, $value);
            }
        }
    }

    static protected function integerProperty($default = NULL) {
        return array(
            'type' => 'int',
            'value' => $default
        );
    }

    static protected function booleanProperty($default = NULL) {
        return array(
            'type' => 'boolean',
            'value' => $default
        );
    }

    static protected function stringProperty($length = 50, $default = NULL) {
        return array(
            'type' => 'string',
            'length' => $length,
            'value' => $default
        );
    }

    static protected function customProperty($className, $default = NULL,
                                             array $extra = array()) {
        return array(
            'type' => '\\'.$className,
            'value' => $default
        ) + $extra;
    }

    static protected function datetimeProperty($default = NULL) {
        if (isset($default) && is_string($default)) {
            $default = new \DateTime($default);
        }

        return self::customProperty('DateTime', $default);
    }

    static protected function propertyProperty(YGLProperty $default = NULL) {
        return self::customProperty('YGL\Properties\YGLProperty', $default);
    }

    static protected function leadProperty(YGLLead $default = NULL) {
        return self::customProperty('YGL\Leads\YGLLead', $default);
    }

    static protected function addressProperty(YGLAddress $default = NULL) {
        return self::customProperty('YGL\Leads\YGLAddress', $default);
    }

    static protected function contactProperty(YGLContact $default = NULL) {
        return self::customProperty('YGL\Leads\YGLContact', $default);
    }

    static protected function residentProperty(YGLLeadResident $default = NULL)
    {
        return self::customProperty('YGL\Leads\YGLLeadResident', $default);
    }

    static protected function referralSourceCollectionProperty(
      YGLReferralSourceCollection $default = NULL) {
        return self::customProperty('YGL\Leads\YGLReferralSourceCollection',
          $default);
    }

    static protected function notesProperty(YGLLeadNotes $default = NULL) {
        return self::customProperty('YGL\Leads\YGLLeadNotes', $default);
    }

    static protected function taskProperty(YGLTask $default = NULL) {
        return self::customProperty('YGL\Tasks\YGLTask', $default);
    }

    static protected function userProperty(YGLUser $default = NULL) {
        return self::customProperty('YGL\Users\YGLUser', $default);
    }

    public function JsonSerialize() {
        $data = array();

        foreach ($this->_properties as $name => $property) {
            if ($property['value'] == NULL) {
                continue;
            }
            $data[ucfirst($name)] = $property['value'];
        }
        return $data;
    }

    public function __set($name, $value) {
        $name = lcfirst($name);
        if (!empty($this->_properties[$name])) {
            $type = $this->_properties[$name]['type'];

            switch ($type) {
                case 'int':
                    $this->_properties[$name]['value'] = (int)$value;
                    break;
                case 'boolean':
                    $this->_properties[$name]['value'] = $value == TRUE;
                    break;
                case 'string':
                    $this->_properties[$name]['value'] = substr($value, 0,
                      $this->_properties[$name]['length']);
                    break;
                default:
                    $this->_properties[$name]['value'] = $value instanceof $type
                      ? $value : new $type($value);
                    break;
            }
        }
    }

    public function __get($name) {
        $name = lcfirst($name);
        if (!empty($this->_properties[$name])) {
            return $this->_properties[$name]['value'];
        }
        return NULL;
    }
} 
