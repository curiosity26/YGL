<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 10:58 AM
 */

namespace YGL\Users;


use YGL\Collection\YGLCollection;
use YGL\Properties\YGLProperty;
use YGL\YGLClient;

class YGLUsersCollection extends YGLCollection implements YGLUsersCollectionInterface {
    protected $property;

    public function __construct(YGLClient $client, array $values = array()) {
        parent::__construct($client);
        $this->__set('collection', $values);
    }

    public function setProperty(YGLProperty $property) {
        if ($property !== $this->property) {
            $this->property = $property;
            foreach ($this->collection as $item) {
                if ($item instanceof YGLUser) {
                    $item->setProperty($property);
                }
            }
        }
        return $this;
    }

    public function getProperty() {
        return $this->property;
    }

    public function append(YGLUser $user) {
        if (isset($this->client)) {
            $user->setClient($this->getClient());
        }
        elseif ($client = $user->getClient()) {
            $this->setClient($client);
        }
        $this->collection[$user->id] = $user;
        return $this;
    }

    public function remove(YGLUser $user) {
        unset($this->collection[$user->id]);
        return $this;
    }

    public function offsetSet($offset, $value) {
        if (isset($offset) && ($item = $this->item($offset))) {
            $this->collection[$offset] = $value;
        }
        else {
            if ($value instanceof YGLUser) {
                $this->append($value);
            }
            else {
                $this->append(new YGLUser((array)$value));
            }
        }

    }

    public function __set($name, $value) {
        if ($name == 'collection' && is_array($value)) {
            foreach ($value as $item) {
                if ($item instanceof YGLUser) {
                    $this->append($item);
                }
                else {
                    $this->append(new YGLUser((array)$item));
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