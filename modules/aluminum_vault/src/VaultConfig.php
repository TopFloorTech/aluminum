<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 9/10/2016
 * Time: 10:50 PM
 */

namespace Drupal\aluminum_vault;


use Drupal\Core\Config\Config;
use Drupal\Core\Form\FormStateInterface;

class VaultConfig {
  /**
   * Invokes the "aluminum_vault_config" hook and returns all config values
   *
   * @return array
   */
  public function getVaultConfig() {
    $vault_config = \Drupal::moduleHandler()->invokeAll('aluminum_vault_config');

    $defaults = [
      '#vault_group' => 'general',
    ];

    return $this->prepareVaultData($vault_config, $defaults);
  }

  /**
   * Invokes the "aluminum_vault_groups" hook and returns all config groups
   *
   * @return array
   */
  public function getVaultGroups() {
    $vault_groups = \Drupal::moduleHandler()->invokeAll('aluminum_vault_groups');

    $defaults = [
      '#type' => 'details',
      '#group' => 'aluminum_vault',
    ];

    return $this->prepareVaultData($vault_groups, $defaults);
  }

  /**
   * Standardizes some defaults for both config options and groups
   *
   * @param $data
   * @param array $defaults
   * @return mixed
   */
  protected function prepareVaultData($data, $defaults = []) {
    foreach ($data as $data_id => $data_array) {
      $data[$data_id] += $defaults + [
          '#vault_id' => $data_id,
          '#title' => $this->getTitleFromId($data_id),
          '#weight' => 0,
        ];
    }

    /*usort($data, function ($a, $b) {
      return $a['weight'] - $b['weight'];
    });*/

    return $data;
  }

  protected function getTitleFromId($id) {
    return ucfirst(str_replace('_', ' ', $id));
  }

  public function getOptionValue($option, FormStateInterface $form_state = null) {
    $config = aluminum_vault_config($option['#vault_group']);

    if (!is_null($form_state) && $form_state->hasValue($option['#vault_id'])) {
      $value = $form_state->getValue($option['#vault_id']);
    } elseif (isset($config[$option['#vault_id']])) {
      $value = $config[$option['#vault_id']];
    } elseif (isset($option['#default_value'])) {
      $value = $option['##default_value'];
    } else {
      $value = '';
    }

    return $value;
  }
}
