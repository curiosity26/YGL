<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:50 PM
 */

namespace YGL\Leads;


use YGL\Collection\YGLCollection;
use YGL\Properties\YGLProperty;
use YGL\YGLClient;

class YGLLeadCollection extends YGLCollection implements YGLLeadCollectionInterface {
    protected $property;

    public function __construct(YGLClient $client = NULL, array $leads = array()) {
        parent::__construct();
        if (isset($client)) {
            $this->setClient($client);
        }
        $this->__set('collection', $leads);
    }

    public function setProperty(YGLProperty $property) {
        if ($property !== $this->property) {
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

    public function append(YGLLead $lead) {
        // Prefer this client
        if (isset($this->client)) {
            $lead->setClient($this->client);
        }
        elseif ($client = $lead->getClient()) {
            $this->setClient($client);
        }

        $this->collection[$lead->id] = $lead;
        return $this;
    }

    public function remove(YGLLead $lead) {
        unset($this->collection[$lead->id]);
        return $this;
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
            if ($value instanceof YGLLead) {
                $this->append($value);
            }
            else {
                $this->append(new YGLLead($value, $this->client));
            }
        }
    }

    public function __set($name, $value) {
        if ($name == 'collection' && is_array($value)) {
            foreach ($value as $item) {
                if ($item instanceof YGLLead) {
                    $this->append($item);
                }
                else {
                    if (is_object($item)) {
                        $item = (array)$item;
                    }

                    $this->append(new YGLLead($item));
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