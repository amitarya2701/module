<?php

namespace Drupal\acfform;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Class AcfCurrentTime.
 *
 * Custom service for get the current timezone as per admin config timezone.
 */
class AcfCurrentTime {

  /**
   * The Date formatter Object.
   *
   * @var string
   */
  protected $dateformatter;
  /**
   * The timezone.
   *
   * @var string
   */
  protected $timezone;

  /**
   * Constructs AcfCurrentTime object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Datetime\DateFormatter $dateformatter
   *   The DateFormatter objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory, DateFormatter $dateformatter) {
    $acf_settings = $config_factory->get('acfform_configuration.settings');
    $this->timezone = $acf_settings->get('timezone');
    $this->dateformatter = $dateformatter;
  }

  /**
   * Get Current time basis on Timezone from Admin Configurations.
   *
   * @return bool
   *   Return TRUE if sms sent successfully else FALSE.
   */
  public function getCurrentTime() {
    $current_time = $this->dateformatter->format(strtotime('now'), 'custom', 'jS M Y - h:i A', $this->timezone);
    return $current_time;
  }

}
