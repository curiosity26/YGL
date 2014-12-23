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
    private $properties = array();

    public function testConnection() {
        $ygl = new YGLClient($this->accessToken);
        $this->properties = $ygl->getProperties();
        //var_dump($this->properties);
        $this->assertNotEquals(0, $this->properties->count());
    }
}
 