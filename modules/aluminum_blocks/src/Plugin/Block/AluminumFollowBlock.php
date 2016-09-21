<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 9/9/2016
 * Time: 2:13 PM
 */

namespace Drupal\aluminum_blocks\Plugin\Block;

/**
 * Provides a 'Follow links' block
 *
 * @Block(
 *     id = "aluminum_follow",
 *     admin_label = @Translation("Follow links"),
 * )
 */
class AluminumFollowBlock extends AluminumBlockBase {
  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    $options = [];

    $weight = 10;

    foreach (aluminum_vault_social_networks() as $id => $name) {
      $options[$id . '_enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t($name . ' enabled'),
        '#description' => $this->t($name . ' will be shown if this box is checked.'),
        '#default_value' => TRUE,
      ];

      $options[$id . '_weight'] = [
        '#type' => 'textfield',
        '#title' => $this->t($name . ' weight'),
        '#description' => $this->t('This integer defines the weight of ' . $name . ' in relation to other links.'),
        '#default_value' => $weight,
      ];

      $weight += 10;
    }

    return $options;
  }

  protected function iconClass($id) {
    $config = aluminum_vault_config();

    $class = $config[$id][$id . '_icon_class'];

    if (!empty($config['general']['base_icon_class'])) {
      $class = $config['general']['base_icon_class'] . ' ' . $class;
    }

    return $class;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = aluminum_vault_config();

    $items = [];
    foreach (aluminum_vault_social_networks() as $id => $name) {
      $items[] = [
        'url' => $config[$id][$id . '_page_url'],
        'icon_class' => $this->iconClass($id),
      ];
    }

    return [
      '#theme' => 'aluminum_follow_list',
      '#list' => $items,
    ];
  }
}
