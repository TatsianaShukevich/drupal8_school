<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Plugin\Block\WeatherBlock.
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
 *   id = "weather_block",
 *   admin_label = @Translation("Current weather data"),
 * )
 */

class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * The service for getting weather.
     * 
     * @var $weatherService \Drupal\openweathermap\WeatherService
     */
    protected $weatherService;

    /**
     * The config.
     *
     * @var \Drupal\Core\Config\Config
     */
    private $config;

    /**
     * The service for render.
     *
     * @var \Drupal\Core\Render\Renderer
     */
    protected $render;

    /**
     * Constructs a WeatherBlock object
     *
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param \Drupal\openweathermap\WeatherService $weatherService
     * @param \Drupal\Core\Render\Renderer $render
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherService $weatherService, Renderer $render) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);

        $this->weatherService = $weatherService;
        $this->render = $render;

        $this->config = \Drupal::config('openweathermap.settings');

    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container,  array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('openweathermap.weather_service'),
            $container->get('renderer')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $build = array();
        $weatherCurrent = $this->config->get('openweathermap.weatherCurrent');
        
        if (!empty($weatherCurrent)) {
            $iconBuild = [
                '#theme' => 'image',
                '#uri' => 'http://openweathermap.org/img/w/' . $weatherCurrent['weather'][0]['icon'] . '.png',
            ];
            //HTML for weather icon.
            $icon = $this->render->render($iconBuild);

            $rows = array(
                array(
                    $this->t('Wind'),
                    $weatherCurrent['wind']['speed'] . ' m/s',
                ),
                array(
                    $this->t('Cloudiness'),
                    $weatherCurrent['clouds']['all'] . ' %',
                ),
                array(
                    $this->t('Pressure'),
                    $weatherCurrent['main']['pressure'] . ' hpa',
                ),
                array(
                    $this->t('Humidity'),
                    $weatherCurrent['main']['humidity'] . ' %',
                ),
                array(
                    $this->t('Sunrise'),
                    date('H:i', $weatherCurrent['sys']['sunrise']),
                ),
                array(
                    $this->t('Sunset'),
                    date('H:i' ,$weatherCurrent['sys']['sunset']),
                ),
            );
            $table_id = 'weather_block';


            $build['weather_block'] = array(
                '#type' => 'container',
                '#attributes' => array(
                    'class' => array('weather-block'),
                ),
            );
            $build['weather_block']['city_name'] = array(
                '#type' => 'html_tag',
                '#tag' => 'h3',
                '#value' => $weatherCurrent['name'] . ', ' . $weatherCurrent['sys']['country'],
            );
            $build['weather_block']['current_temp'] = array(
                '#type' => 'html_tag',
                '#tag' => 'h2',
                '#attributes' => array(
                    'id' => array('weather_temp'),
                ),
                '#value' => $icon . ' ' . $weatherCurrent['main']['temp'] . ' °C'
            );
            $build['weather_block']['weather_desc'] = array(
                '#type' => 'html_tag',
                '#tag' => 'p',
                '#value' => $weatherCurrent['weather'][0]['description']
            );
            $build['weather_block']['weather_date'] = array(
                '#type' => 'html_tag',
                '#tag' => 'p',
                '#value' => 'get at ' . date('D j M Y H:i', $weatherCurrent["dt"])
            );
            $build['weather_block']['weather_table'] = array(
                '#type' => 'table',
                '#rows' => $rows,
                '#attributes' => array(
                    'id' => $table_id,
                ),
                '#attached' => array(
                    'library' => array('openweathermap/weather_table'),
                ),
            );
        }

        return $build;
    }
}