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
     * The service for answers.
     *
     * @var \Drupal\magic_ball\AnswerService
     */
    protected $render;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('lesson4.weather_service'),
            $container->get('renderer')
        );
    }

    /**
     * Constructs an MagicController object.
     *
     * @param \Drupal\lesson4\WeatherService $weatherService
     *   The service for weather.
     * @param \Drupal\Core\Render\Renderer $render
     */
    public function __construct($weatherService, $render) {
        $this->weatherService = $weatherService;
        $this->render = $render;
    }

    /**
     * Shows page with table as example for Render API.
     *
     * @return array
     */
    public function showRenderApiExamplePage() {


        drupal_set_message($this->weatherService->getCityName());

        $weatherPerDay = $this->weatherService->getWeatherPerDay();

        $rows = array();


            $rows[] = array(
                'data' => array(
                    array(
                        'data' =>  date('j M'),
                        'colspan' => 2,
                        'class' => 'weather-date')
                ),
            );





        foreach($weatherPerDay as $date => $weather) {

            $dayMonth = date('j M', $date);
            $time = date('H i', $date);


            $iconBuild = [
                '#theme' => 'image',
                '#uri' => 'http://openweathermap.org/img/w/' . $weather['weather'][0]['icon'] . '.png',
            ];


            $icon = $this->render->render($iconBuild);

            $rightCellBuild = array(
                'temperature' => array(
                    // We wrap the fieldnote content up in a div tag.
                    '#type' => 'html_tag',
                    '#tag' => 'span',
                    // This text is auto-XSS escaped.  See docs for the html_tag element.
                    '#value' => $weather['temp']['temp'] . '°C',
                    // Let's give the note a nice sticky-note CSS appearance.
                    '#attributes' => array(
                        'class' => 'label label-warning',
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

            $leftCell = $this->render->render($leftCellBuild);
            $rightCell = $this->render->render($rightCellBuild);



            if ($time == '00 00') {
                $rows[] = array(
                    'data' => array(
                        array(
                            'data' =>  $dayMonth,
                            'colspan' => 2,
                            'class' => 'weather-date'
                        )
                    ),
                    'no_striping' => TRUE,
                );
            }
            $rows[] = array(
                'data' => array(
                    $leftCell,
                    $rightCell
                ),
                'no_striping' => TRUE,
            );
        }


//        $headers = array(
//            t('Date'),
//            t('Temp'),
//            t('Pressure'),
//            t('Weather'),
//            t('Wind'),
//            t('Pic'),
//        );


        $table_id = 'lesson4';



        return array(
            '#type' => 'table',
            '#rows' => $rows,
            '#prefix' => '<div class="daily_list">',
            '#suffix' => '</div>',
            '#attributes' => array(
            'id' => $table_id,
            ),
            // ..And this is the CSS for the stickynote.
            '#attached' => array(
                'library' => array('lesson4/weather_table'),
            ),


        );


    }
}