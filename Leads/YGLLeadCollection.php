<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:50 PM
 */

namespace YGL\Leads;


use YGL\Interfaces\YGLLeadCollectionInterface;
use YGL\YGLClient;

class YGLLeadCollection implements YGLLeadCollectionInterface,\JsonSerializable, \Countable {
    protected $collection = array();
    private $client;

    public function __construct(array $leads = array()) {
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
                if ($item instanceof YGLLead) {
                    if (isset($this->client)) {
                        $item->setClient($this->client);
                    }

                    $this->collection[$item->id] = $item;
                }
                else {
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