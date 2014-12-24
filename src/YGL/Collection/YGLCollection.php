<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/23/14
 * Time: 3:02 PM
 */

namespace YGL\Collection;

abstract class YGLCollection implements \JsonSerializable, \Countable, \Iterator, \ArrayAccess {
  protected $collection = array();

  public function __construct(array $values = array()) {
    $this->collection = $values;
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

  public function offsetSet($offset, $value) {
    if (!is_null($offset) && is_numeric($offset)) {
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