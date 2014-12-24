<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:14 PM
 */

namespace YGL\Properties;

use YGL\Collection\YGLCollectionInterface;

interface YGLPropertyCollectionInterface extends YGLCollectionInterface {
    public function append(YGLProperty $property);
    public function remove(YGLProperty $property);
}