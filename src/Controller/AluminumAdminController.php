<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 9/10/2016
 * Time: 10:29 PM
 */

namespace Drupal\aluminum\Controller;


use Drupal\Core\Controller\ControllerBase;

class AluminumAdminController extends ControllerBase {
  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t('This is the Aluminum configuration section. Use the child pages of this section to configure Aluminum.') . '</p>',
    ];

    return $build;
  }
}
