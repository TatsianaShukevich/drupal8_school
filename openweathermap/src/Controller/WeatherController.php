<?php
/**
 * @file
 * Contains \Drupal\openweathermap\Controller\WeatherController.
 */

namespace Drupal\openweathermap\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;
use Drupal\openweathermap\WeatherService;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller routines for openweathermap module routes.
 */
class WeatherController extends ControllerBase {

    /**
     * The service for getting weather.
     *
     * @var \Drupal\openweathermap\WeatherService
     */
    protected $weatherService;

    /**
     * The service for render.
     *
     * @var \Drupal\Core\Render\Renderer
     */
    protected $render;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('openweathermap.weather_service'),
            $container->get('renderer')
        );
    }

    /**
     * Constructs an WeatherController object.
     *
     * @param \Drupal\openweathermap\WeatherService $weatherService
     *   The service for weather.
     * @param \Drupal\Core\Render\Renderer $render
     *   The service for render.
     */
    public function __construct(WeatherService $weatherService, Renderer $render) {
        $this->weatherService = $weatherService;
        $this->render = $render;
    }

    /**
     * Shows page with weather data for 5 days forecast.
     *
     * @return array
     */
    public function showWeatherPage() {

        //5 day forecast. It includes weather data every 3 hours.
        $weatherPerDay = $this->weatherService->getWeatherPerDay();

        if(!empty($weatherPerDay)) {
            //The formation of rows of a table.
            $rows = array();

            //Date in Mon 01 Jan 2016 format.
            $dayMonth = '';

            foreach($weatherPerDay as $date => $weather) {

                //Separates forecast by day.
                if(date('D j M Y', $date) !== $dayMonth) {
                    $dayMonth = date('D j M Y', $date);
                    $rows[] = array(
                        'data' => array(
                            array(
                                'data' =>  $dayMonth,
                                'colspan' => 2,
                                'class' => 'weather-date')
                        ),
                    );
                }

                $time = date('H:i', $date);

                $iconBuild = [
                    '#theme' => 'image',
                    '#uri' => 'http://openweathermap.org/img/w/' . $weather['weather'][0]['icon'] . '.png',
                ];
                //HTML for weather icon.
                $icon = $this->render->render($iconBuild);

                $rightCellBuild = array(
                    'temperature' => array(
                        '#type' => 'html_tag',
                        '#tag' => 'span',
                        '#value' => $weather['temp']['temp'] . '°C',
                        '#attributes' => array(
                            'class' => 'temp-avg',
                        ),
                    ),
                    'description' => array(
                        '#type' => 'html_tag',
                        '#tag' => 'i',
                        '#value' => $weather['weather'][0]['description'],
                    ),
                    'weather' => array(
                        '#type' => 'html_tag',
                        '#tag' => 'p',
                        '#value' => $weather['wind']['speed'] . 'm/s</br> clouds: ' . $weather['clouds']['all'] . '%, ' . $weather['temp']['pressure'] . ' hpa',
                        '#attributes' => array(
                            'class' => 'weather',
                        ),
                    ),
                );

                $leftCellBuild = array(
                    'date' => array(
                        '#markup' => $time,
                    ),
                    'icon' => array(
                        '#markup' => $icon,

                    ),
                );

                //HTML for a left cell of table.
                $leftCell = $this->render->render($leftCellBuild);
                //HTML for a right cell of table.
                $rightCell = $this->render->render($rightCellBuild);

                $rows[] = array(
                    'data' => array(
                        $leftCell,
                        $rightCell
                    ),
                    'no_striping' => TRUE,
                );
            }

            $table_id = 'weather_table';

            return array(
                'city' => array(
                    '#type' => 'html_tag',
                    '#tag' => 'h3',
                    '#value' => $this->weatherService->getCityName(),
                    '#attributes' => array(
                        'class' => 'city-name',
                    ),
                ),
                'daily_list' => array(
                    '#type' => 'table',
                    '#rows' => $rows,
                    '#prefix' => '<div class="daily-list">',
                    '#suffix' => '</div>',
                    '#attributes' => array(
                        'id' => $table_id,
                    ),
                    '#attached' => array(
                        'library' => array('openweathermap/weather_table'),
                    ),
                )
            );
        }
        else {
            $response = new Response(
                'Content',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
            $response->setContent('The service currently unavailable. Please run cron');

// the headers public attribute is a ResponseHeaderBag
            $response->headers->set('Content-Type', 'text/plain');

            return $response->setStatusCode(Response::HTTP_NOT_FOUND);

//            return array(
//                '#markup' => $this->t('The service currently unavailable. Please run cron')
//            );
        }
    }

    public function showWeatherMapPage() {
        return array(
            '#type' => 'weather_tile_map',
        );
    }
}