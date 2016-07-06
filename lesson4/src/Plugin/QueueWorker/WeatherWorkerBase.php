<?php
/**
 * @file
 * Contains Drupal\lesson4\Plugin\QueueWorker\WeatherWorkerBase.
 */

namespace Drupal\lesson4\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides base functionality for the Weather Queue Workers.
 */
abstract class WeatherWorkerBase extends QueueWorkerBase implements ContainerFactoryPluginInterface
{

    /**
     * The config.
     *
     * @var \Drupal\Core\Config\Config
     */
    private $config;

    /**
     * Creates a new WeatherWorkerBase object.
     *
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     */
    public function __construct($configuration, $plugin_id, $plugin_definition) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        //$this->nodeStorage = $node_storage;
        $this->config = \Drupal::config('lesson4.settings');
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition
        );
    }

    /**
     * Publishes a node.
     *
     * @param NodeInterface $node
     * @return int
     */
//    protected function publishNode($node)
//    {
//        $node->setPublished(true);
//
//        return $node->save();
//    }

    /**
     * {@inheritdoc}
     */
    public function processItem($data) {
        var_dump($data);
        \Drupal::configFactory()
            ->getEditable('lesson4.settings')
            ->set('lesson4.weather', 'test')
            ->save();

    }
}