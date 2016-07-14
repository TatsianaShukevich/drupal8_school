<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Element\WeatherMap.
 */

namespace Drupal\openweathermap\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Url;

/**
 * Provides WeatherMap element.
 *
 * @RenderElement("weather_map")
 */
class WeatherMap extends RenderElement {
    /**
     * {@inheritdoc}
     */
    public function getInfo() {
        $class = get_class($this);
        return [
            '#theme' => 'weather_map',
            '#pre_render' => [
                [$class, 'preRenderWeatherMap'],
            ],
        ];
    }

    /**
     * Prepare the render array for the template.
     */
    public static function preRenderWeatherMap($element) {
        // Add the library
        $element['#attached'] = [
            'library' => [
                'openweathermap/openlayers',
                'openweathermap/openweathermap',
                'openweathermap/weather-map'
            ],
        ];
        
        return $element;
    }
}