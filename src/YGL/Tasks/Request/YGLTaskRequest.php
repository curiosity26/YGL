<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 10:40 AM
 */

namespace YGL\Tasks\Request;


use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLRequest;
use YGL\Tasks\YGLTask;
use YGL\Tasks\YGLTaskCollection;

class YGLTaskRequest extends YGLRequest {
  protected $property;
  protected $lead;
  protected $id;

  public function __construct($clientToken = FALSE, YGLProperty $property = NULL,
                              YGLLead $lead = NULL, $id = NULL,
                              ODataResourceInterface $query = NULL) {
    parent::__construct($clientToken, $query);
    if (isset($property)) {
      $this->setProperty($property);
    }
    if (isset($lead)) {
      $this->setLead($lead);
    }
    $this->id($id);
  }

  public function id($id = NULL) {
    $this->id = $id;
    if (isset($this->property)) {
      $function = 'properties/'.$this->property->id;
      if (isset($this->lead)) {
        $function .= '/leads/'.$this->lead->id;
      }
      $function .= '/tasks';
      if (isset($id)) {
        $function .= '/'.$id;
      }
      $this->setFunction($function);
    }
    return $this;
  }

  public function setProperty(YGLProperty $property) {
    $this->property = $property;
    $this->id($this->id); // Refresh the function
    return $this;
  }

  public function getProperty() {
    return $this->property;
  }

  public function setLead(YGLLead $lead) {
    $this->lead = $lead;
    $this->id($this->id); // Refresh the function
    return $this;
  }

  public function getLead() {
    return $this->lead;
  }

  public function send() {
    $response = parent::send();
    if ($response->isSuccess()) {
      $body = $response->getResponseCode() != 201
        ? json_decode($response->getBody())
        : json_decode($response->getResponse()->getRawResponse());
      if (is_array($body)) {
        $tasks = new YGLTaskCollection($this->getClient(), $body);
        $tasks->rewind();
        if (isset($this->lead)) {
          $tasks->setLead($this->getLead());
        }
        elseif (isset($this->property)) {
          $tasks->setProperty($this->getProperty());
        }

        return $tasks->count() > 1 ? $tasks->rewind() : $tasks->rewind()->current();
      }
      $task = new YGLTask((array)$body, $this->getClient());
      if (isset($this->lead)) {
        $task->setLead($this->getLead());
      }
      elseif (isset($this->property)) {
        $task->setProperty($this->getProperty());
      }
      return $task;
    }
    return $response;
  }
}