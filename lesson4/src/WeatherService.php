<?php
/**
 * @file
 * Contains \Drupal\lesson4\WeatherService.
 */

namespace Drupal\lesson4;

use Drupal\Core\Config;

/**
 * Gets weather from http://openweathermap.org/ web services.
 */
class WeatherService {

    const LESSON4_WEATHER_SERVICE_5DAYS = 'http://api.openweathermap.org/data/2.5/forecast/city?id=625144&units=metric&APPID=9c9c7fc2cd7bcdd06a4b869983cd2aca';
    const LESSON4_WEATHER_SERVICE_CURRENT = 'http://api.openweathermap.org/data/2.5/weather?id=625144&units=metric&appid=9c9c7fc2cd7bcdd06a4b869983cd2aca';


    /**
     * Constructs a CurrenciesService object.
     */
    public function __construct() {
        $this->config = \Drupal::config('lesson4.settings');
    }


    /**
     * Gets and writes to configs currencies from NBRB web services.
     */
    public function getWeather5Days() {

        $weather= array();
        $date = '';

        $client = \Drupal::httpClient();
        $request = $client->get(self::LESSON4_WEATHER_SERVICE_5DAYS);
        //$responseXML = $request->getBody();
        //var_dump($request->getBody());
        $response = json_decode($request->getBody(), true);
       // die(var_dump($response));
        
        \Drupal::configFactory()
            ->getEditable('lesson4.settings')
            ->set('lesson4.weather', $response)
            ->save();

//        if (!empty($request) && isset($responseXML)) {
//
//            $data = new \SimpleXMLElement($responseXML);
//            foreach ($data->Currency as $value) {
//                $currencies[] = array(
//                    'CharCode' => (string)$value->CharCode,
//                    'Name' => (string)$value->Name,
//                    'Rate' => (string)$value->Rate,
//                );
//            }
//
//            foreach ($data->attributes() as $key => $val) {
//                $date .= (string) $val;
//            }
//
//            \Drupal::configFactory()
//                ->getEditable('lesson3.settings')
//                ->set('lesson3.currencies', $currencies)
//                ->set('lesson3.date', $date)
//                ->save();
//        }

       // return $currencies;
    }


    public function getCurrentWeather() {

        $weather= array();
        $date = '';

        $client = \Drupal::httpClient();
        $request = $client->get(self::LESSON4_WEATHER_SERVICE_CURRENT);
        //$responseXML = $request->getBody();
        //var_dump($request->getBody());
        $response = json_decode($request->getBody(), true);
        // die(var_dump($response));

        \Drupal::configFactory()
            ->getEditable('lesson4.settings')
            ->set('lesson4.weatherCurrent', $response)
            ->save();

//        if (!empty($request) && isset($responseXML)) {
//
//            $data = new \SimpleXMLElement($responseXML);
//            foreach ($data->Currency as $value) {
//                $currencies[] = array(
//                    'CharCode' => (string)$value->CharCode,
//                    'Name' => (string)$value->Name,
//                    'Rate' => (string)$value->Rate,
//                );
//            }
//
//            foreach ($data->attributes() as $key => $val) {
//                $date .= (string) $val;
//            }
//
//            \Drupal::configFactory()
//                ->getEditable('lesson3.settings')
//                ->set('lesson3.currencies', $currencies)
//                ->set('lesson3.date', $date)
//                ->save();
//        }

        // return $currencies;
    }

    public function getCityName() {
        $weather = $this->config->get('lesson4.weather');
        return $weather['city']['name'];
    }

    
    public function getWeatherPerDay() {
        $weather = $this->config->get('lesson4.weather');
        $weatherPerDay = array();
        foreach ($weather['list'] as $weatherDay) {
            $weatherPerDay[$weatherDay['dt']] = array(
                'temp' => $weatherDay['main'],
                'weather' => $weatherDay['weather'],
                'clouds' => $weatherDay['clouds'],
                'wind' => $weatherDay['wind'],
                'rain' => $weatherDay['rain'],
                
            );
        }
        return $weatherPerDay;
    }
}
