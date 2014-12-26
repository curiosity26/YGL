<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:03 PM
 */

namespace YGL;

use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Leads\YGLLeadCollection;
use YGL\Properties\YGLProperty;
use YGL\Leads\Request\YGLLeadRequest;
use YGL\Properties\Request\YGLPropertyRequest;
use YGL\Tasks\Request\YGLTaskRequest;
use YGL\Users\Request\YGLUserRequest;
use YGL\Tasks\YGLTask;
use YGL\Tasks\YGLTaskCollection;

class YGLClient {
    protected $username;
    protected $password;

    public function __construct($accessToken = NULL, $password = NULL) {
        if (isset($accessToken)) {
            $this->setAccessToken($accessToken, $password);
        }
    }

    public function setAccessToken($userToken, $password = NULL) {
        if (!isset($password)) {
            list($username, $password) = explode(':',
              base64_decode($userToken));
            $this->username = $username;
            $this->password = $password;
        }
        else {
            $this->username = $userToken;
            $this->password = $password;
        }
        return $this;
    }

    public function getAccessToken() {
        return base64_encode($this->username.':'.$this->password);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getProperties($id = NULL, $limit = 20,
                                  ODataResourceInterface $query = NULL) {
        $ygl = new YGLPropertyRequest($this, $id, $limit, $query);
        return $ygl->send();
    }

    public function getLeads(YGLProperty $property, $id = NULL,
                             ODataResourceInterface $query = NULL) {
        $request = new YGLLeadRequest($this, $property, $id, $query);
        return $request->send();
    }

    public function addLead(YGLProperty $property, YGLLead $lead) {
        $request = new YGLLeadRequest($this, $property);
        $request->setBody($lead);
        return $request->send();
    }

    public function addLeads(YGLProperty $property, YGLLeadCollection $leads) {
        $request = new YGLLeadRequest($this, $property);
        $request->setBody($leads);
        return $request->send();
    }

    public function getTasks(YGLProperty $property, YGLLead $lead = NULL,
                             $id = NULL, ODataResourceInterface $query = NULL) {
        $request = new YGLTaskRequest($this, $property, $lead, $id, $query);
        return $request->send();
    }

    public function addTask(YGLProperty $property, YGLLead $lead, YGLTask $task) {
        $request = new YGLTaskRequest($this, $property, $lead);
        $request->setBody($task);
        return $request->send();
    }

    public function addTasks(YGLProperty $property,
                            YGLLead $lead, YGLTaskCollection $tasks) {
        $request = new YGLTaskRequest($this, $property, $lead);
        $request->setBody($tasks);
        return $request->send();
    }

    public function getUsers(YGLProperty $property, $id = NULL,
                             ODataResourceInterface $query = NULL) {
        $request = new YGLUserRequest($this, $property, $id, $query);
        return $request->send();
    }

} 