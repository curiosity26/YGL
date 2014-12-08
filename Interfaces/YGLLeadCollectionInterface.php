<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:15 PM
 */

namespace YGL\Interfaces;


use YGL\Leads\YGLLead;

interface YGLLeadCollectionInterface {
    public function append(YGLLead $lead);
    public function remove(YGLLead $lead);
    public function clear();
    public function item($id);
}