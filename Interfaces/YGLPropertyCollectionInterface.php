<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/7/14
 * Time: 8:14 PM
 */

namespace YGL\Interfaces;

use YGL\Properties\YGLProperty;

interface YGLPropertyCollectionInterface {
    public function append(YGLProperty $property);
    public function remove(YGLProperty $property);
    public function clear();
    public function item($id);
}