<?php

namespace Drupal\acfform\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a Config Form.
 */
class ACFConfigForm extends ConfigFormBase {

  /**
   * Get Form ID.
   *
   * @return string
   *   Return Form ID for Config Form.
   */
  public function getFormId() {
    return 'acfform_configuration_admin_settings';
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return [
      'acfform_configuration.settings',
    ];
  }

  /**
   * Build Admin Configuration form.
   *
   * @param array $form
   *   Form to be rendered.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormStateInterface Object to render form.
   *
   * @return array
   *   Return Admin Configuration Form for Site Location and timezone.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('acfform_configuration.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Country'),
      '#description' => $this->t('Store Country'),
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter City'),
      '#description' => $this->t('Store City'),
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => ('Select Timezone'),
      '#options' => [
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London'),
      ],
      '#default_value' => $config->get('timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit and Save Admin Configuration for Site location and timezone.
   *
   * @param array $form
   *   Form to be rendered.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormStateInterface Object to render form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('acfform_configuration.settings');
    $config->set('country', $form_state->getValue('country'))->save();
    $config->set('city', $form_state->getValue('city'))->save();
    $config->set('timezone', $form_state->getValue('timezone'))->save();

  }

}
