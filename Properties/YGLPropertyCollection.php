<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 7:19 PM
 */

namespace YGL\Properties;

use YGL\Collection\YGLCollection;
use YGL\Interfaces\YGLPropertyCollectionInterface;
use YGL\YGLClient;

class YGLPropertyCollection extends YGLCollection implements  YGLPropertyCollectionInterface {
    protected $client;

    public function __construct(YGLClient $client = NULL, array $properties = array()) {
        parent::__construct();
        if (isset($client)) {
            $this->setClient($client);
        }
        $this->__set('collection', $properties);
    }

    public function setClient(YGLClient $client) {
        $this->client = $client;
        if ($this->count() > 0) {
            foreach ($this->collection as $item) {
                if ($item instanceof YGLProperty) {
                    $item->setClient($client);
                }
            }
        }
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function append(YGLProperty $property) {
        if (isset($this->client)) {
            $property->setClient($this->client);
        }
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

    public function offsetSet($offset, $value) {
        if (isset($offset) && ($property = $this->item($offset))) {
            $this->collection[$offset] = $value;
        }
        else {
            if ($value instanceof YGLProperty) {
                if (isset($this->client)) {
                    $value->setClient($this->client);
                }

                $this->collection[$value->id] = $value;
            }
            else {
                $property = new YGLProperty($value, $this->client);
                $this->collection[$property->id] = $property;
            }
        }
    }

    public function __set($name, $value) {
        if ($name == 'collection' && (is_array($value))) {
            foreach ($value as $item) {
                if ($item instanceof YGLProperty) {
                    if (isset($this->client)) {
                        $item->setClient($this->client);
                    }
                    $this->collection[$item->id] = $item;
                }
                else {
                    if (is_object($item)) {
                        $item = (array)$item;
                    }
                    $property = new YGLProperty((array)$item, $this->client);
                    $this->collection[$property->id] = $property;
                }
            }
        }
        elseif ($name == 'client' && $value instanceof YGLClient) {
            $this->setClient($value);
        }
    }

    public function __get($name) {
        if ($name == 'collection') {
            return $this->collection;
        }
        elseif ($name == 'client') {
            return $this->getClient();
        }
        return NULL;
    }
} 