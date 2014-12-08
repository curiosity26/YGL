<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:54 PM
 */

namespace YGL\Leads;


use YGL\Interfaces\YGLReferralSourceCollectionInterface;

class YGLReferralSourceCollection implements YGLReferralSourceCollectionInterface,\JsonSerializable, \Countable {
    protected $collection = array();

    public function __construct(array $values = array()) {
        $this->__set('collection', $values);
    }

    public function append(YGLReferralSource $source) {
        $this->collection[$source->id] = $source;
        return $this;
    }

    public function remove(YGLReferralSource $source) {
        unset($this->collection[$source->id]);
        return $this;
    }

    public function clear()
    {
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
        return $this->collection;
    }

    public function __set($name, $value) {
        if ($name == 'collection' && is_array($value)) {
            foreach ($value as $item) {
                if ($item instanceof YGLReferralSource) {
                    $this->collection[$item->id] = $item;
                }
                else {
                    $source = new YGLReferralSource($item);
                    $this->collection[$source->id] = $source;
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