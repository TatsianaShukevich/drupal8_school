<?php
/**
 * @file
 * Contains \Drupal\magic_ball\Form\MagicQuestionForm.
 */

namespace Drupal\magic_ball\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Question Form for magic-ball module.
 */
class MagicQuestionForm extends FormBase {

    /**
     * The service for answers.
     *
     * @var \Drupal\magic_ball\AnswerService
     */
    protected $answerService;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('magic_ball.answer_service')
        );
    }

    /**
     * Constructs an MagicQuestionForm object.
     *
     * @param \Drupal\magic_ball\AnswerService $answerService
     *   The service for answers.
     */
    public function __construct($answerService) {
        $this->answerService = $answerService;
    }

    /**
     * {@inheritdoc}.
     */
    public function getFormId() {
        return 'magic_form';
    }

    /**
     * {@inheritdoc}.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['question'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Type your question here please')
        );
        $form['ask'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Ask'),
        );

        return $form;
    }

    /**
     * {@inheritdoc}.
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->answerService->getAnswer();
    }
}