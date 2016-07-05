<?php
/**
 * @file
 * Contains \Drupal\magic_ball\Event\MagicPageLoadEvent.
 */

namespace Drupal\magic_ball\Event;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Config\Config;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines event for page loading.
 */
class MagicPageLoadEvent extends Event {

    /**
     * The config.
     *
     * @var \Drupal\Core\Config\Config
     */
    private $config;

    /**
     * The current user object.
     *
     * @var \Drupal\Core\Session\AccountInterface
     */
    private $user;
    
    /**
     * Constructs an MagicPageLoadEvent object.
     *
     * @param \Drupal\Core\Config\Config $config
     * @param \Drupal\Core\Session\AccountInterface $user
     */
    public function __construct(Config $config, AccountInterface $user) {
        $this->config = $config;
        $this->user = $user;        
    }
    
    /**
     * Getter for the current user's name.
     *
     * @return string
     */
    public function getUserName() {
        return $this->user->getDisplayName();
    }

    /**
     * Getter for the Hello phrase from settings file.
     *
     * @return string
     */

    public function getMagicHelloPhrase() {
        return $this->config->get('magic_ball.magicHelloPhrase');
    }

    /**
     * Setter for the Hello phrase from settings file.
     *
     * @param string $newHelloPhrase
     *   New Hello phrase.
     */

    public function setMagicHelloPhrase($newHelloPhrase) {
         $this->config->set('magic_ball.magicHelloPhrase', $newHelloPhrase);
    }
}