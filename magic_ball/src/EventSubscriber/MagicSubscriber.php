<?php

/**
 * @file
 * Contains Drupal\magic_ball\EventSubscriber\MagicSubscriber.
 */

namespace Drupal\magic_ball\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\magic_ball\Event\MagicEvents;

/**
 * Configures handlers for magic-ball modules.
 */
class MagicSubscriber implements EventSubscriberInterface {

    /**
     * {@inheritdoc}
     */
    static function getSubscribedEvents() {
        $events[MagicEvents::PAGE_LOAD][] = array('onMagicPageLoad', 0);    
        return $events;
    }

    /**
     * Shows a message when /magic-ball page was loaded.
     *
     * @param \Drupal\magic_ball\Event\MagicPageLoadEvent $event
     *   The page loading event.
     */
    public function onMagicPageLoad($event) {
        $userName = $event->getUserName();
        $magicHelloPhrase = $event->getMagicHelloPhrase();
        drupal_set_message($magicHelloPhrase . ', ' . $userName);
    }
}