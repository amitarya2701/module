<?php

namespace Drupal\acfform\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\acfform\AcfCurrentTime;

/**
 * Provides a 'ACF Timezone Block' block.
 *
 * @Block(
 *   id = "acfform_timezone_block",
 *   admin_label = @Translation("ACF Timezone Block")
 * )
 */
class ACFSiteBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current time.
   *
   * @var string
   */
  protected $acfform;

  /**
   * The Country.
   *
   * @var string
   */
  protected $country;

  /**
   * The City.
   *
   * @var string
   */

  protected $city;

  /**
   * Create Objects from Dependency Injection for custom services.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   ContainerInterface object for DI.
   * @param array $configuration
   *   Configuration array.
   * @param string $plugin_id
   *   Plugin ID.
   * @param mixed $plugin_definition
   *   Plugin Definition.
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('acfform.current_time'),
      $container->get('config.factory')
    );
  }

  /**
   * Constructs ACFSiteBlock Object.
   *
   * @param array $configuration
   *   Configuration array.
   * @param string $plugin_id
   *   Plugin ID.
   * @param mixed $plugin_definition
   *   Plugin Definition.
   * @param \Drupal\acfform\AcfCurrentTime $acfform
   *   Custom Service AcfCurrentTime Object.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AcfCurrentTime $acfform, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $acf_settings = $config_factory->get('acfform_configuration.settings');
    $this->country = $acf_settings->get('country');
    $this->city = $acf_settings->get('city');
    $this->acfform = $acfform;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $current_time = $this->acfform->getCurrentTime();

    $renderable = [
      '#theme' => 'block_acfform',
      '#city' => $this->city,
      '#country' => $this->country,
      '#current_time' => $current_time,
    ];

    return $renderable;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // If you need to redefine the Max Age for that block.
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['url.path', 'url.query_args'];
  }

}
