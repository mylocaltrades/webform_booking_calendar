<?php

namespace Drupal\webform_booking_calendar\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Webform Booking Calendar block.
 *
 * @Block(
 *   id = "webform_booking_calendar_block",
 *   admin_label = @Translation("Webform Booking Calendar")
 * )
 */
class WebformBookingCalendarBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get configuration values.
    $config = $this->getConfiguration();
    $webform_ids = !empty($config['webform_ids']) ? $config['webform_ids'] : [];
    $element_names = !empty($config['element_names']) ? $config['element_names'] : [];

    // Ensure required values are set.
    if (empty($webform_ids) || empty($element_names)) {
      return [
        '#markup' => $this->t('Please configure this block to select Webforms and elements.'),
      ];
    }

    // Attach the calendar and pass the configuration to JavaScript.
    return [
      '#markup' => '<div id="calendar-' . $this->getPluginId() . '"></div>',
      '#attached' => [
        'library' => ['webform_booking_calendar/fullcalendar'],
        'drupalSettings' => [
          'webformBookingCalendar' => [
            $this->getPluginId() => [
              'webform_ids' => array_values($webform_ids),
              'element_names' => array_values($element_names),
            ],
          ],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    // Get existing configuration.
    $config = $this->getConfiguration();

    // Load all Webforms.
    $webforms = \Drupal::entityTypeManager()
      ->getStorage('webform')
      ->loadMultiple();

    $options = [];
    foreach ($webforms as $webform) {
      $options[$webform->id()] = $webform->label();
    }

    // Add form elements.
    $form['webform_ids'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Select Webforms'),
      '#options' => $options,
      '#default_value' => $config['webform_ids'] ?? [],
      '#required' => TRUE,
    ];

    $form['element_names'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Booking Element Keys'),
      '#default_value' => !empty($config['element_names']) ? implode("\n", $config['element_names']) : '',
      '#description' => $this->t('Enter one booking element key per line.'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('webform_ids', array_filter($form_state->getValue('webform_ids')));
    $this->setConfigurationValue(
      'element_names',
      array_filter(preg_split('/\r\n|\r|\n/', $form_state->getValue('element_names')))
    );
  }
}
