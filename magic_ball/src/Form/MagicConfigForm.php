<?php
/**
 * @file
 * Contains \Drupal\magic_ball\Form\MagicConfigForm.
 */

namespace Drupal\magic_ball\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for configuration magic-ball module.
 */
class MagicConfigForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'magic_config_form';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'magic_ball.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {        

        $form['key_phrase'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Key'),
            '#required' => TRUE,
        );
        $form['new_phrase'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('New phrase'),
            '#required' => TRUE,
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
//    public function validateForm(array &$form, FormStateInterface $form_state) {
//        $key = $form_state->getValue('key_phrase');
//
//        if ($this->config('magic_ball.settings')->get("magic_ball.$key")) {
//            
//            $form_state->setErrorByName('key_phrase', $this->t('This key already exists'));
//        }
//
//        parent::validateForm($form, $form_state);
//    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $key_phrase = $form_state->getValue('key_phrase');

        $this->config('magic_ball.settings')
            ->set("magic_ball.$key_phrase", $form_state->getValue('new_phrase'))
            ->save();
  
        parent::submitForm($form, $form_state);
    }
}