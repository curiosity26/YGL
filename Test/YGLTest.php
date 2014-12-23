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
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\YGLPropertyCollection $properties
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
    }

}
 