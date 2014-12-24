<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:15 PM
 */

namespace YGL\Leads;



use YGL\Collection\YGLCollectionInterface;

interface YGLLeadCollectionInterface extends YGLCollectionInterface {
    public function append(YGLLead $lead);
    public function remove(YGLLead $lead);
}