<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 10:55 AM
 */

namespace YGL\Tasks;


use YGL\Collection\YGLCollection;
use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\YGLClient;

class YGLTaskCollection extends YGLCollection implements YGLTaskCollectionInterface {
  protected $property;
  protected $lead;

  public function __construct(YGLClient $client, array $values = array()) {
    parent::__construct($client);
    $this->__set('collection', $values);
  }

  public function setProperty(YGLProperty $property) {
    if ($property !== $this->property) { // Don't waste clock cycles
      // Prefer this client if set, otherwise use the property's client if possible
      if (!isset($this->client) && ($client = $property->getClient())) {
        $this->setClient($client);
      }
      $this->property = $property;
      foreach ($this->collection as $item) {
        $item->setProperty($property);
      }
    }
    return $this;
  }

  public function getProperty() {
    return $this->property;
  }

  public function setLead(YGLLead $lead) {
    // TaskCollections can have tasks from different leads.
    // Setting the lead on the collection will override any leads currently set
    // on individual tasks.
    if ($lead !== $this->lead) {
      if ($property = $lead->getProperty()) {
        $this->setProperty($property);
      }

      // Prefer the task from the property before the lead,
      // they're the same if it's set on the lead
      if (isset($this->client)) {
        $lead->setClient($this->client);
      }
      elseif ($client = $lead->getClient()) {
        $this->setClient($client);
      }
      $this->lead = $lead;
      foreach ($this->collection as $item) {
        $item->setLead($lead);
      }
    }

    return $this;
  }

  public function getLead() {
    return $this->lead;
  }

  public function append(YGLTask $task) {
    // Prefer this client if set, otherwise use the property's client if possible
    if (isset($this->client)) {
      $task->setClient($this->client);
    }
    elseif ($client = $task->getClient()) {
      $this->setClient($client);
    }

    // Prefer the incoming task's property settings
    if ($property = $task->getProperty()) {
      $this->setProperty($property);
    }
    elseif (isset($this->property)) {
      $task->setProperty($this->property);
    }

    // Because Tasks can have different leads,
    // we won't set the lead for the collection
    $this->collection[$task->id] = $task;
    return $this;
  }

  public function remove(YGLTask $task) {
    unset($this->collection[$task->id]);
  }

  public function clear() {
    $this->collection = array();
    return $this;
  }

  public function offsetSet($offset, $value) {
    if (isset($offset) && ($lead = $this->item($offset))) {
      $this->collection[$offset] = $value;
    }
    else {
      if ($value instanceof YGLTask) {
        $this->append($value);
      }
      else {
        $this->append(new YGLTask($value));
      }
    }
  }

  public function __set($name, $value) {
    if ($name == 'collection' && is_array($value)) {
      foreach ($value as $item) {
        if ($item instanceof YGLTask) {
          $this->append($item);
        }
        else {
          if (is_object($item)) {
            $item = (array)$item;
          }
          $this->append(new YGLTask($item));
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