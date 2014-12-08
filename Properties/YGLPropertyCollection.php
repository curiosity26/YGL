<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 7:19 PM
 */

namespace YGL\Properties;

use YGL\Interfaces\YGLPropertyCollectionInterface;

class YGLPropertyCollection implements  YGLPropertyCollectionInterface,\JsonSerializable, \Countable {
    protected $collection = array();

    public function __construct(array $properties = array()) {
        $this->__set('collection', $properties);
    }

    public function append(YGLProperty $property) {
        $this->collection[$property->id] = $property;
        return $this;
    }

    public function remove(YGLProperty $property) {
        unset($this->collection[$property->id]);
        return $this;
    }

    public function clear() {
        $this->collection = array();
        return $this;
    }

    public function count() {
        return count($this->collection);
    }

    public function item($id) {
        if (is_numeric($id) && !empty($this->collection[$id])) {
            return $this->collection[$id];
        }
        return FALSE;
    }

    public function JsonSerialize() {
        return array_values($this->collection);
    }

    public function __set($name, $value) {
        if ($name == 'collection' && (is_array($value))) {
            foreach ($value as $item) {
                if ($item instanceof YGLProperty) {
                    $this->collection[$item->id] = $item;
                }
                else {
                    $property = new YGLProperty((array)$item);
                    $this->collection[$property->id] = $property;
                }
            }
        }
    }

    public function __get($name) {
        if ($name == 'collection') {
            return $this->collection;
        }
        return NULL;
    }
} 