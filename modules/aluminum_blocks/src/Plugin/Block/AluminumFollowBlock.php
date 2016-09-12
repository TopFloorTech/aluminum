<?php
/**
 * Created by PhpStorm.
 * User: BMcClure
 * Date: 9/9/2016
 * Time: 2:13 PM
 */

namespace Drupal\aluminum_blocks\Plugin\Block;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'Follow links' block
 *
 * @block(
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
        '#default_value' => 10,
      ];

      $weight += 10;
    }

    return $options;
  }

  protected function iconClass($id) {
    $base_class = aluminum_vault_config('general.base_icon_class');
    $class = aluminum_vault_config($id . '.' . $id . '_icon_class');

    if (!empty($base_class)) {
      $class = $base_class . ' ' . $class;
    }

    return $class;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $icon_template = '<i class="%s"></i>';
    $items = [];

    foreach (aluminum_vault_social_networks() as $id => $name) {
      $url = Url::fromUri($this->getOptionValue($id . '_page_url'));
      $icon = sprintf($icon_template, $this->iconClass($id));

      $items[] = Link::fromTextAndUrl($icon, $url);
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items,
    ];
  }
}
