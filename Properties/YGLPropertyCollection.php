<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 7:19 PM
 */

namespace YGL\Properties;

use YGL\Interfaces\YGLPropertyCollectionInterface;
use YGL\YGLClient;

class YGLPropertyCollection implements  YGLPropertyCollectionInterface, \JsonSerializable, \Countable {
    protected $collection = array();
    protected $client;

    public function __construct(array $properties = array(), YGLClient $client = NULL) {
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
                    if (isset($this->client)) {
                        $item->setClient($this->client);
                    }
                    $this->collection[$item->id] = $item;
                }
                else {
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