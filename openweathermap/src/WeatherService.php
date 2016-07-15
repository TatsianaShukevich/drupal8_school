<?php
/**
 * @file
 * Contains \Drupal\openweathermap\WeatherService.
 */

namespace Drupal\openweathermap;

use Drupal\Core\Config;

/**
 * Gets weather from http://openweathermap.org/ web services.
 * 
 *  5 day / 3 hour forecast API
 *  @see http://openweathermap.org/forecast5
 *  Current weather data API
 *  @see http://openweathermap.org/current
 *  
 */
class WeatherService {
    
    const OPENWEATHERMAP_WEATHER_SERVICE_5DAYS = 'http://api.openweathermap.org/data/2.5/forecast/city';
    const OPENWEATHERMAP_WEATHER_SERVICE_CURRENT = 'http://api.openweathermap.org/data/2.5/weather';

    /**
     * Constructs a CurrenciesService object.
     */
    public function __construct() {
        $this->config = \Drupal::config('openweathermap.settings');
    }


    /**
     * Gets and writes to configs weather data for 5 days.
     * 
     *  Request parameters
     *  id - city id in city list
     *  @see http://openweathermap.org/forecast5#cityid5
     *  units - units format 
     *  @see http://openweathermap.org/forecast5#format
     *  APPID - to get access to weather API
     *  @see http://openweathermap.org/appid
     * 
     */
    public function getWeather5Days() {
        $client = \Drupal::httpClient();
        
        $response = $client->request('GET', self::OPENWEATHERMAP_WEATHER_SERVICE_5DAYS, array(
            'query' => array(
                'id' => '625144',
                'units' => 'metric',
                'APPID' => '9c9c7fc2cd7bcdd06a4b869983cd2aca'
            )
        ));

        if($response->getStatusCode() == 200) {
            $weatherData = json_decode($response->getBody(), true);

            \Drupal::configFactory()
                ->getEditable('openweathermap.settings')
                ->set('openweathermap.weather', $weatherData)
                ->save();
        }         
    }

    /**
     * Gets and writes to configs current weather data.
     * 
     *  Request parameters
     *  id - city id in city list
     *  @see http://openweathermap.org/forecast5#cityid5
     *  units - units format
     *  @see http://openweathermap.org/forecast5#format
     *  APPID - to get access to weather API
     *  @see http://openweathermap.org/appid
     */
    public function getCurrentWeather() {

        $client = \Drupal::httpClient();

        $response = $client->request('GET', self::OPENWEATHERMAP_WEATHER_SERVICE_CURRENT, array(
            'query' => array(
                'id' => '625144',
                'units' => 'metric',
                'APPID' => '9c9c7fc2cd7bcdd06a4b869983cd2aca'
            )
        ));

        if($response->getStatusCode() == 200) {            
            $weatherCurrentData = json_decode($response->getBody(), true);

            \Drupal::configFactory()
                ->getEditable('openweathermap.settings')
                ->set('openweathermap.weatherCurrent', $weatherCurrentData)
                ->save();
        }

    }

    /**
     * Gets city name.
     */
    public function getCityName() {
        $weather = $this->config->get('openweathermap.weather');
        if (!empty($weather)) {
            return $weather['city']['name'];
        }
        else return '';
    }

    /**
     * Gets weather data for 5 days as array date => weatherData.
     */
    public function getWeatherPerDay() {
        $weather = $this->config->get('openweathermap.weather');
        $weatherPerDay = array();
        
        if (!empty($weather)) {
            foreach ($weather['list'] as $weatherDay) {
                $weatherPerDay[$weatherDay['dt']] = array(
                    'temp' => $weatherDay['main'],
                    'weather' => $weatherDay['weather'],
                    'clouds' => $weatherDay['clouds'],
                    'wind' => $weatherDay['wind'],
                    'rain' => $weatherDay['rain'],
                );
            } 
        }
        
        return $weatherPerDay;
    }
}
