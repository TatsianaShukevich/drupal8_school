<?php
namespace Drupal\lesson4\Plugin\QueueWorker;

use Drupal\lesson4\Plugin\QueueWorker\WeatherWorkerBase;

/**
 * A Node Publisher that publishes nodes on CRON run.
 *
 * @QueueWorker(
 *   id = "weather_worker",
 *   title = @Translation("Cron Node Publisher"),
 *   cron = {"time" = 10}
 * )
 */
class WeatherWorker extends WeatherWorkerBase {}