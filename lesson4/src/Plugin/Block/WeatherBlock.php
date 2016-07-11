<?php
/**
 * @file
 * Contains \Drupal\lesson3\Plugin\Block\CurrenciesBlock.
 */

namespace Drupal\lesson4\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lesson4\WeatherService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/**
 * Provides a block with current weather.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Current weather block"),
 * )
 */

class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * @var $weatherService \Drupal\lesson4\WeatherService
     */
    protected $weatherService;

    /**
     * The config.
     *
     * @var \Drupal\Core\Config\Config
     */
    private $config;

    /**
     * Constructs a WeatherBlock object
     *
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param \Drupal\lesson4\WeatherService $weatherService
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherService $weatherService) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);

        $this->weatherService = $weatherService;

        $this->config = \Drupal::config('lesson4.settings');

    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container,  array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('lesson4.weather_service')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {


        return array(
//            // We wrap the fieldnote content up in a div tag.
//            '#type' => 'html_tag',
//            '#tag' => 'div',
//            // This text is auto-XSS escaped.  See docs for the html_tag element.
//            '#children' => array(
//                'city_name' => array(
//                    '#type' => 'html_tag',
//                    '#tag' => 'h3',
//                    '#value' => 'Minsk, BY'
//                ),
//            ),
//            // Let's give the note a nice sticky-note CSS appearance.
//            '#attributes' => array(
//                'class' => 'weather-block',
//            ),

            'city_name' => array(


            ),
            'current_temp' => array(

            ),
            'weather_desc' => array(

            ),
            'weather_table' => array(

            )

        );
    }

//    /**
//     * {@inheritdoc}
//     */
//
//    public function blockForm($form, FormStateInterface $form_state) {
//
//        $configBlock = $this->getConfiguration();
//        $currencies = $this->config->get('lesson3.currencies');
//
//        if (!isset($currencies) || empty($currencies)) {
//            $currencies = $this->currenciesService->getCurrencies();
//        }
//
//        $form = parent::blockForm($form, $form_state);
//
//        foreach ($currencies as $currency) {
//            $arrayCharCode = $configBlock['check' . $currency['CharCode']];
//            $form['check' . $currency['CharCode']] = array(
//                '#type' => 'checkbox',
//                '#title' => $currency['Name'],
//                '#default_value' => $arrayCharCode['Checked'],
//            );
//        }
//
//        return $form;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function blockSubmit($form, FormStateInterface $form_state) {
//        $currencies = $this->config->get('lesson3.currencies');
//
//        if (!isset($currencies) || empty($currencies)) {
//            $currencies = $this->currenciesService->getCurrencies();
//        }
//
//        foreach ($currencies as $currency) {
//            $this->setConfigurationValue('check' . $currency['CharCode'], array(
//                'Checked' => $form_state->getValue('check' . $currency['CharCode']),
//                'Name' => $currency['Name'],
//                'Rate' => $currency['Rate'],
//            ));
//        }
//    }
}