<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 10/8/2016
 * Time: 9:35 PM
 */

namespace Drupal\aluminum\Aluminum\Traits;


trait StaticInvokableTrait {
  protected static $hookData = [];

  protected static function invokeHook($hookName, $defaultItem = []) {
    if (!isset(self::$hookData[$hookName])) {
      $moduleHandler = \Drupal::moduleHandler();

      $data = $moduleHandler->invokeAll($hookName);
      $moduleHandler->alter($hookName, $data);

      self::$hookData[$hookName] = $data;
    }

    $data = self::$hookData[$hookName];

    if (!empty($defaultItem)) {
      foreach ($data as $id => $value) {
        $data[$id] = $value + $defaultItem;
      }
    }

    return $data;
  }
}
