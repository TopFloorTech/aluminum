<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 9/10/2016
 * Time: 5:57 PM
 */

namespace Drupal\aluminum_vault\Form;


use Drupal\aluminum\Aluminum\Vault\VaultConfig;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure settings for Aluminum
 */
class AluminumVaultSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aluminum_vault_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['config.aluminum_vault'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config.aluminum_vault');

    $vault_config = new VaultConfig();

    $form['aluminum_vault'] = [
      '#type' => 'vertical_tabs',
      '#title' => 'Aluminum vault',
    ];

    foreach ($vault_config->getVaultGroups() as $group_id => $group) {
      $form['aluminum_vault'][$group_id] = $group;
    }

    foreach ($vault_config->getVaultConfig() as $option_id => $option) {
      $option['#default_value'] = $vault_config->getOptionValue($option, $form_state, $config);

      $form['aluminum_vault'][$option['#vault_group']][$option_id] = $option;
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('config.aluminum_vault');

    $vault_config = new VaultConfig();

    foreach ($vault_config->getVaultConfig() as $option_id => $option) {
      $config->set($option_id, $form_state->getValue(['aluminum_vault', $option['#vault_group'], $option_id]));
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }
}
