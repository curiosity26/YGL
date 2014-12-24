<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/24/14
 * Time: 10:56 AM
 */

namespace YGL\Tasks;


use YGL\Collection\YGLCollectionInterface;

interface YGLTaskCollectionInterface extends YGLCollectionInterface {
  public function append(YGLTask $task);
  public function remove(YGLTask $task);
}