<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Element\WeatherTileMap.
 */

namespace Drupal\openweathermap\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides WeatherTileMap element.
 * 
 *  Element can be used once on the same page.
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
            '#width' => '100%',
            '#height' => '400px',
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
                'openweathermap/weather_tile_map'
            ],
            'drupalSettings' => [
                'weather_tile_map' => [
                    'width' =>  $element['#width'],
                    'height' => $element['#height'],
                ],
            ],
        ];

        return $element;
    }
}