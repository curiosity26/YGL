<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:50 PM
 */

namespace YGL\Leads;


use YGL\Collection\YGLCollection;
use YGL\Interfaces\YGLLeadCollectionInterface;
use YGL\Properties\YGLProperty;
use YGL\YGLClient;

class YGLLeadCollection extends YGLCollection implements YGLLeadCollectionInterface {
    protected $client;
    protected $property;

    public function __construct(YGLClient $client = NULL, array $leads = array()) {
        parent::__construct();
        if (isset($client)) {
            $this->setClient($client);
        }
        $this->__set('collection', $leads);
    }

    public function setClient(YGLClient $client) {
        $this->client = $client;
        if ($this->count() > 0) {
            foreach ($this->collection as $item) {
                $item->setClient($client);
            }
        }
        return $this;
    }

    public function getClient() {
        return $this->client;
    }

    public function setProperty(YGLProperty $property) {
        if ($property !== $this->property) {
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
                if (isset($this->client)) {
                    $value->setClient($this->client);
                }

                $this->collection[$value->id] = $value;
            }
            else {
                $lead = new YGLLead($value, $this->client);
                $this->collection[$lead->id] = $lead;
            }
        }
    }

    public function __set($name, $value) {
        if ($name == 'collection' && is_array($value)) {
            foreach ($value as $item) {
                if ($item instanceof YGLLead) {
                    if (isset($this->client)) {
                        $item->setClient($this->client);
                    }

                    $this->collection[$item->id] = $item;
                }
                else {
                    if (is_object($item)) {
                        $item = (array)$item;
                    }

                    $lead = new YGLLead($item, $this->client);
                    $this->collection[$lead->id] = $lead;
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