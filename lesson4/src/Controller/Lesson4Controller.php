<?php
/**
 * @file
 * Contains \Drupal\lesson4\Controller\Lesson4Controller.
 */

namespace Drupal\lesson4\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Controller routines for lesson4 module routes.
 */
class Lesson4Controller extends ControllerBase {

    /**
     * The service for answers.
     *
     * @var \Drupal\magic_ball\AnswerService
     */
    protected $weatherService;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('lesson4.weather_service')
        );
    }

    /**
     * Constructs an MagicController object.
     *
     * @param \Drupal\lesson4\WeatherService $weatherService
     *   The service for weather.
     */
    public function __construct($weatherService) {   
        $this->weatherService = $weatherService;
    }

    /**
     * Shows page with table as example for Render API.
     *
     * @return array
     */
    public function showRenderApiExamplePage() {

        //$weather = $this->config('lesson4.settings')->get('lesson4.weather');

        //die(var_dump($weather));
        
        drupal_set_message($this->weatherService->getCityName());

        $weatherPerDay = $this->weatherService->getWeatherPerDay();

       // var_dump($weather);
        $rows = array();
//        $output[] = theme('image_style', array(
//            'style_name' => $style_name,
//            'path' => $path,
//            'attributes' => $attributes,
//        ));

//        $img = array(
//            '#type' => 'image_style',
//            'path' => 'http://openweathermap.org/img/w/' . $weather['weather'][0]['icon'] . '.png',
//
//        );



        foreach($weatherPerDay as $date => $weather) {
            $img = array(
                '#type' => 'image_style',
                'path' => 'http://openweathermap.org/img/w/' . $weather['weather'][0]['icon'] . '.png',

            );
            $img = render($img);

            $rows[] = array(
                'data' => array(
                    $date,
                    $weather['temp']['temp'],
                    $weather['temp']['pressure'],
                    $weather['weather'][0]['description'],
                    $weather['wind']['speed'],
                    $img
                ),
            );
        }

//        $rows[] = array(
//            'data' => array('a','s',$weather),
//
//        );
        $headers = array();
        $headers[] = t('Date');
        $headers[] = t('Temp');
        $headers[] = t('Pressure');
        $headers[] = t('Weather');
        $headers[] = t('Wind');
        $headers[] = t('Pic');

        $table_id = 'lesson4';



        return array(
            '#type' => 'table',
            '#header' => $headers,
            '#rows' => $rows,
            '#attributes' => array(
            'id' => $table_id,
        ));


    }
}