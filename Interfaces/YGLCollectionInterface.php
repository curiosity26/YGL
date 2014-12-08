<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:06 PM
 */

namespace YGL\Interfaces;


use YGL\Leads\YGLLead;
use YGL\Leads\YGLReferralSource;
use YGL\Properties\YGLProperty;
use YGL\YGLJsonObject;

interface YGLCollectionInterface {
    public function append(YGLJsonObject $item);
    public function remove(YGLJsonObject $item);
    public function clear();
    public function item($id);
}