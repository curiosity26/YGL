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

require_once __DIR__.'/../autoload.php';
use \YGL\YGL;

class YGLTest extends \PHPUnit_Framework_TestCase {
    private $accessToken = 'eWdsQXBpVGVzdDE6cGFzc3dvcmQ=';
    private $properties = array();

    public function testConnection() {
        $ygl = new YGL($this->accessToken);
        $this->properties = $ygl->getProperties();
        $this->assertNotEquals(0, $this->properties->count());
    }
}
 