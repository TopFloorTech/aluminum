<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 10/8/2016
 * Time: 9:35 PM
 */

namespace Drupal\aluminum\Aluminum\Traits;


trait InvokableTrait {
  protected $hookData = [];

  protected function invokeHook($hookName) {
    if (!isset($this->hookData[$hookName])) {
      $moduleHandler = \Drupal::moduleHandler();

      $data = $moduleHandler->invokeAll($hookName);
      $moduleHandler->alter($hookName, $data);

      $this->hookData[$hookName] = $data;
    }

    return $this->hookData[$hookName];
  }
}
