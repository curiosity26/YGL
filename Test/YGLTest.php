<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:05 PM
 */

// Test Encryption: eWdsQXBpVGVzdDE6cGFzc3dvcmQ=
// Test User = yglApiTest1
// Test Password = password

use \YGL\YGLClient;

class YGLTest extends \PHPUnit_Framework_TestCase {
    private $accessToken = 'eWdsQXBpVGVzdDE6cGFzc3dvcmQ=';

    /**
     * @return \YGL\YGLClient
     */
    public function testConnection() {
        $ygl = new YGLClient($this->accessToken);
        $request = new \YGL\Request\YGLRequest($ygl);
        $request->setFunction('properties');
        $response = $request->send();
        $this->assertTrue($response->isSuccess());
        return $ygl;
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     * @return \YGL\Properties\YGLPropertyCollection
     */
    public function testPropertiesList(YGLClient $ygl) {
        $properties = $ygl->getProperties();
        $this->assertNotEmpty($properties);
        return $properties;
        //return $properties instanceof \YGL\Properties\YGLProperty ? new \YGL\Properties\YGLPropertyCollection($ygl, array($properties)) : $properties;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\YGLPropertyCollection $properties
     * @return \YGL\Properties\YGLProperty
     */
    public function testPropertiesGet(\YGL\Properties\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $ygl = $properties->getClient();
        $this->assertTrue($ygl instanceof YGLClient);
        if ($ygl instanceof YGLClient) {
            $get_property = $ygl->getProperties($property->id);
            $this->assertEquals($property->id, $get_property->id);
            $this->assertEquals($property->name, $get_property->name);
        }
        return $property;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\YGLPropertyCollection $properties
     * @return \YGL\Leads\YGLLeadCollection
     */
    public function testLeadsList(\YGL\Properties\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $leads = $property->getLeads();
        $this->assertNotEmpty($leads);
        return $leads;
    }

    /**
     * @depends testLeadsList
     * @param \YGL\Leads\YGLLeadCollection $leads
     */
    public function testLeadsGet(\YGL\Leads\YGLLeadCollection $leads) {
         $lead = $leads->rewind()->current();
         $get_lead = $lead->getProperty()->getLeads($lead->id);
         $this->assertEquals($lead->id, $get_lead->id);
         $this->assertEquals($lead->primaryContact->id, $get_lead->primaryContact->id);
        return $lead;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\YGLPropertyCollection $properties
     * @return \YGL\Leads\YGLLead
     */
    public function testLeadPost(\YGL\Properties\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $lead = new \YGL\Leads\YGLLead(array(
            'addedOn' => new DateTime(),
            'associate' => 'SageAPITest',
            'primaryContact' => new \YGL\Leads\Contact\YGLContact(array(
                'firstName' => 'Bob',
                'lastName'  => 'Jones',
                'gender'    => 'M',
                'isInquirer'=> TRUE,
                'address'   => new \YGL\Leads\Address\YGLAddress(array(
                    'address1'  => '17 Pierce Lane',
                    'city'      => 'Montoursville',
                    'state'     => 'Pennsylvania',
                    'zip'       =>  '17754'
                ))
            )),
            'userName' => 'Guest5'
        ));
        $response = $property->addLead($lead);
        $this->assertEquals('Bob', $response->primaryContact->firstName);
        $this->assertEquals('Jones', $response->primaryContact->lastName);
        return $response;
    }

    /**
     * @depends testPropertiesGet
     * @param \YGL\Properties\YGLProperty $property
     */
    public function testPropertyTasksList(\YGL\Properties\YGLProperty $property) {
        $tasks = $property->getTasks();
        $this->assertNotEmpty($tasks);
    }

    /**
     * @depends testLeadsGet
     * @param \YGL\Leads\YGLLead $lead
     * @return mixed
     */
    public function testLeadTasksList(\YGL\Leads\YGLLead $lead) {
        $tasks = $lead->getTasks();
        $this->assertNotEmpty($tasks);
        return $tasks->current();
    }

    /**
     * @depends testLeadTasksList
     * @param \YGL\Tasks\YGLTask $task
     */
    public function testLeadTasksGet(\YGL\Tasks\YGLTask $task) {
        $lead = $task->getLead();
        $get_task = $lead->getTasks($task->id);
        $this->assertEquals($task->id, $get_task->id);
    }

    /**
     * @depends testLeadsGet
     * @param \YGL\Leads\YGLLead $lead
     */
    public function testLeadTasksAdd(\YGL\Leads\YGLLead $lead) {
        $task = new \YGL\Tasks\YGLTask(array(
          'contactId' => 135224,
          'taskTitle' => 'Test Post Task',
          'taskTypeId'=> 24
        ));
        $response = $lead->addTask($task);
        var_dump($response);
        $this->assertNotNull($response->id);
    }

}
 