<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 11:27 PM
 */

namespace YGL\Request;

use ODataQuery\ODataResourceInterface;
use ODataQuery\Pager\ODataQueryPager;
use YGL\Properties\YGLPropertyCollection;

class YGLPropertyRequest extends YGLRequest {

    public function __construct($clientToken = NULL, $id = NULL, $limit = 20,
                                ODataResourceInterface $query = NULL) {
        parent::__construct($clientToken, $query);
        $this->id($id);
        $this->pager(new ODataQueryPager($limit));
    }

    public function id($id = NULL) {
        $this->setFunction(isset($id) ? 'properties/'.$id : 'properties');
        return $this;
    }

    public function send() {
        $properties = new YGLPropertyCollection();
        $response = parent::send();
        if ($response->isSuccess()) {
            $properties->collection = json_decode($response->getBody());
        }

        return $properties;
    }
} 