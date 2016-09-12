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
 * Provides a 'Phone number' block
 *
 * @block(
 *     id = "aluminum_phone_number",
 *     admin_label = @Translation("Phone number"),
 * )
 */
class AluminumPhoneNumberBlock extends AluminumBlockBase {
  protected function getPhoneNumberOptions() {
    $options = [];

    foreach (aluminum_vault_phone_numbers() as $phone_number_type => $info) {
      $options[$phone_number_type] = $info['title'];
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    return [
      'phone_number_type' => [
        '#type' => 'select',
        '#title' => $this->t('Phone number type'),
        '#description' => $this->t('Choose which phone number type to display.'),
        '#options' => $this->getPhoneNumberOptions(),
        '#default_value' => 'phone_number',
      ],
    ];
  }

  protected function getLink($type) {
    $phone_number = aluminum_vault_config('contact_info.' . $type);
    $url = Url::fromUri('tel:+1 ' . $phone_number);

    return Link::fromTextAndUrl($phone_number, $url);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => sprintf('<p>%s</p>', $this->getLink($this->getOptionValue('phone_number_type'))),
    ];
  }
}
