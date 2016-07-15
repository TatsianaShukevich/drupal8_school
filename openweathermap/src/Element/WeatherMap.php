<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Element\WeatherMap.
 */

namespace Drupal\openweathermap\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides WeatherMap element.
 *
 * Element can be used once on the same page.
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
            '#width' => '100%',
            '#height' => '400px',
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
                'openweathermap/weather_map'
            ],
            'drupalSettings' => [
                'weather_map' => [
                    'width' =>  $element['#width'],
                    'height' => $element['#height'],
                ],
            ],
        ];
        
        return $element;
    }
}