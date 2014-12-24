<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:16 PM
 */

namespace YGL\Leads\ReferralSource;


interface YGLReferralSourceCollectionInterface {
    public function append(YGLReferralSource $source);
    public function remove(YGLReferralSource $source);
    public function clear();
    public function item($id);
}