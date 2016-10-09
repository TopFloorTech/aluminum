<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 10/8/2016
 * Time: 9:35 PM
 */

namespace Drupal\aluminum\Aluminum\Traits;


trait InvokableTrait {
  protected static function invokeHook($hookName) {
    $moduleHandler = \Drupal::moduleHandler();

    $data = $moduleHandler->invokeAll($hookName);
    $moduleHandler->alter($hookName, $data);

    return $data;
  }
}
