<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Element\WeatherTileMap.
 */

namespace Drupal\openweathermap\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides WeatherMap element.
 *
 * @RenderElement("weather_tile_map")
 */
class WeatherTileMap extends RenderElement {
    /**
     * {@inheritdoc}
     */
    public function getInfo() {
        $class = get_class($this);
        return [
            '#theme' => 'weather_tile_map',
            '#pre_render' => [
                [$class, 'preRenderWeatherTileMap'],
            ],
        ];
    }

    /**
     * Prepare the render array for the template.
     */
    public static function preRenderWeatherTileMap($element) {
        // Add the library
        $element['#attached'] = [
            'library' => [
                'openweathermap/openlayers',
                'openweathermap/openweathermap',
                'openweathermap/weather-tile-map'
            ],
        ];

        return $element;
    }
}