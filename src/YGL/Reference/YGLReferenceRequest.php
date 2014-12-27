<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 1:14 PM
 */

namespace YGL\Reference;


use ODataQuery\ODataResourceInterface;
use YGL\Request\YGLCollectionRequest;
use YGL\Request\YGLRequest;
use YGL\YGLClient;

abstract class YGLReferenceRequest extends YGLCollectionRequest
{
    protected $id = 0; //SubscriptionId

    public function __construct(YGLClient $client, $id = NULL, ODataResourceInterface $query)
    {
        parent::__construct($client, $query);
        $this->id($id);
    }

    public function id($id = null)
    {
        $this->id = $id;
        $this->refreshFunction();

        return $this;
    }

    public function setFunction($function) {
        $function = 'reference/'.$function;
        return parent::setFunction($function);
    }
}