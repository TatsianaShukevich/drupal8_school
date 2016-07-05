<?php
/**
 * @file
 * Contains \Drupal\magic_ball\Event\MagicEvents.
 */

namespace Drupal\magic_ball\Event;

/**
 * Defines events for the magic-ball module.
 *
 * @see \Drupal\magic_ball\Event\MagicPageLoadEvent
 */
final class MagicEvents {
    /**
     * Name of the event when Magic page is loaded.
     *
     * This event allows modules to perform an action whenever the Magic Page is loaded. The event listener method
     * receives a \Drupal\magic_ball\EventSubscriber\MagicSubscriber instance.
     *
     * @Event
     *
     * @see \Drupal\magic_ball\Event\MagicPageLoadEvent
     *
     * @var string
     */
    const PAGE_LOAD = 'magic.page_load';    
}