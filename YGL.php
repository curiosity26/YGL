<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:03 PM
 */

namespace YGL;

use YGL\Leads\YGLLead;
use YGL\Properties\YGLProperty;
use YGL\Request\YGLLeadRequest;
use YGL\Request\YGLPropertyRequest;
use YGL\Tasks\YGLTask;
use YGL\Users\YGLUser;

class YGL {
    private $accessToken;

    public function __construct($accessToken = NULL, $password = NULL) {
        if (isset($accessToken)) {
            $this->setAccessToken($accessToken, $password);
        }
    }

    public function setAccessToken($accessToken, $password = NULL) {
        if (!isset($password)) {
            $this->accessToken = $accessToken;
        }
        else {
            $this->accessToken = base64_encode($accessToken.':'.$password);
        }
    }

    public function getProperties($id = NULL, $limit = 20) {
        $ygl = new YGLPropertyRequest($this->accessToken, $id, $limit);
        return $ygl->send();
    }

    public function getLeads(YGLProperty $property, $id = NULL) {
        $request = new YGLLeadRequest($this->accessToken, $property, $id);
        return $request->send();
    }

    public function setLead(YGLProperty $property, YGLLead $lead) {
        $request = new YGLLeadRequest($this->accessToken, $property);
        $request->setBody($lead);
        return $request->send();
    }

    public function getTasks(YGLProperty $property, YGLLead $lead) {

    }

    public function setTask(YGLProperty $property, YGLLead $lead, YGLTask $task) {

    }

    public function getUsers(YGLProperty $property, YGLUser $user = NULL) {

    }

} 