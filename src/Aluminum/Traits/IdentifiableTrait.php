<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 10/8/2016
 * Time: 8:22 PM
 */

namespace Drupal\aluminum\Aluminum\Traits;


use Drupal\aluminum\Aluminum\Exception\AluminumException;

trait IdentifiableTrait {
  public function getId() {
    if (!isset($this->id)) {
      throw new AluminumException("No ID set for this object.");
    }

    return $this->id;
  }

  public function getName($translate = TRUE) {
    $name = (!empty($this->name)) ? $this->name : $this->generateName();

    if ($translate) {
      if (method_exists($this, 't')) {
        $name = $this->t($name);
      } else {
        $name = t($name);
      }
    }

    return $name;
  }

  public function generateName() {
    $id = $this->getId();

    if (!$id) {
      throw new AluminumException("No ID, can't generate name.");
    }

    $id = preg_replace('/[_-]+/', ' ', $id);
    $id = ucfirst($id);

    return $id;
  }
}
