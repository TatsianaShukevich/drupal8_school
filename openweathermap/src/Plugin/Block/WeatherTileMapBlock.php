<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Plugin\Block\WeatherTileMapBlock.
 */

namespace Drupal\openweathermap\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\openweathermap\WeatherService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Renderer;

/**
 * Provides a block with current weather data.
 *
 * @Block(
 *   id = "weather_tile_map_block",
 *   admin_label = @Translation("Weather tile map"),
 * )
 */

class WeatherTileMapBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * Constructs a WeatherTileMapBlock object
     *
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container,  array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#type' => 'weather_tile_map',
            '#width' => '100%',
            '#height' => '600px',
        );
    }
}