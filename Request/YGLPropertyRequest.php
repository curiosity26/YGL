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
use YGL\Properties\YGLProperty;
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
        $response = parent::send();
        if ($response->isSuccess()) {
            $body = $response->getResponseCode() != 201 ? json_decode($response->getBody())
                : json_decode($response->getResponse()->getRawResponse());
            if (is_array($body)) {
                $properties = new YGLPropertyCollection($this->getClient(), $body);
                // Currently, the default behavior of the API returns a single
                // object which is converted to a YGLProperty. But if an instance
                // would ever occur when the result is an array with one object,
                // we would want that single object returned to conform to the
                // standard behavior.
                return $properties->count() > 0 ? $properties->rewind()  : $properties->rewind()->current();
            }
            return new YGLProperty((array)$body, $this->getClient());
        }

        return $response;
    }
} 