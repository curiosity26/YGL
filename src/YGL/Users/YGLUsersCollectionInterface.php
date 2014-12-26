<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/26/14
 * Time: 10:59 AM
 */

namespace YGL\Users;


use YGL\Collection\YGLCollectionInterface;

interface YGLUsersCollectionInterface  extends YGLCollectionInterface {
    public function append(YGLUser $user);
    public function remove(YGLUser $user);
}