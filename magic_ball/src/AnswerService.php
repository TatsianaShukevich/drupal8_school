<?php
/**
 * @file
 * Contains \Drupal\magic_ball\AnswerService.
 */

namespace Drupal\magic_ball;

use Drupal\Core\Config;

/**
 * Manages answer for magic-ball module.
 */
class AnswerService {
    
    /**
     * The config.
     *
     * @var \Drupal\Core\Config\Config
     */
    protected $config;

    /**
     * Constructs an MagicPageLoadEvent object.
     */
    public function __construct() {
        $this->config = \Drupal::config('magic_ball.settings');       
    }

    /**
     * Generates list of existing answers in configuration file.
     * 
     * @return string
     */
    public function getPhrasesList() {
        $phrases = $this->config->getRawData();
        $phrases_markup = '';

        foreach ($phrases['magic_ball'] as $key_phrase => $phrase) {
            if ($key_phrase == 'magicHelloPhrase') continue;

            $phrases_markup .= "[$key_phrase] => " . $phrase . '</br>';
        }
        
        return $phrases_markup;
    }

    /**
     * Generates random answer and shows it with message.
     */
    public  function  getAnswer() {
        $phrases = $this->config->get();

        $randomPhrase = array_rand($phrases['magic_ball'], 1);
        if ($randomPhrase == 'magicHelloPhrase') {
            drupal_set_message("Try again please");
        }
        else {
            drupal_set_message($this->config->get("magic_ball.$randomPhrase"));
        }
    }    
}