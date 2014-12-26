<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/23/14
 * Time: 3:02 PM
 */

namespace YGL\Collection;

use YGL\YGLClient;

abstract class YGLCollection implements \JsonSerializable, \Countable, \Iterator, \ArrayAccess {
  protected $collection = array();
  protected $client;

  public function __construct(YGLClient $client = NULL, array $values = array()) {
    if (isset($client)) {
      $this->setClient($client);
    }

    $this->collection = $values;
  }

  public function setClient(YGLClient $client) {
    if ($client !== $this->client) {
      $this->client = $client;
      if ($this->count() > 0) {
        foreach ($this->collection as $item) {
          if (property_exists($item, 'setClient')) {
            $item->setClient($client);
          }
        }
      }
    }
    return $this;
  }

  public function getClient() {
    return $this->client;
  }

  public function count() {
    return count($this->collection);
  }

  public function item($id) {
    if (is_numeric($id) && !empty($this->collection[$id])) {
      return $this->collection[$id];
    }
    return NULL;
  }

  public function JsonSerialize() {
    return array_values($this->collection);
  }

  public function valid() {
    $key = $this->key();
    return isset($this->collection[$key]);
  }

  public function key() {
    return key($this->collection);
  }

  public function current() {
    return current($this->collection);
  }

  public function next() {
    next($this->collection);
    return $this;
  }

  public function prev() {
    prev($this->collection);
    return $this;
  }

  public function rewind() {
    reset($this->collection);
    return $this;
  }

  public function clear() {
    $this->collection = array();
    return $this;
  }

  public function offsetSet($offset, $value) {
    if (!is_null($offset) && is_numeric($offset)) {
      if (isset($this->client) && property_exists($value, 'setClient')) {
        $value->setClient($this->getClient());
      }
      $this->collection[$offset] = $value;
    }
  }

  public function offsetExists($offset) {
    return isset($this->collection[$offset]);
  }

  public function offsetUnset($offset) {
    unset($this->collection[$offset]);
  }

  public function offsetGet($offset) {
    return $this->item($offset);
  }
}