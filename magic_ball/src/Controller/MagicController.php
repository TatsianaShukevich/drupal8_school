<?php
/**
 * @file
 * Contains \Drupal\magic_ball\Controller\MagicController.
 */

namespace Drupal\magic_ball\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\magic_ball\Event\MagicPageLoadEvent;
use Drupal\magic_ball\Event\MagicEvents;

/**
 * Controller routines for magic-ball routes.
 */
class MagicController extends ControllerBase {

    /**
     * The form builder.
     *
     * @var \Drupal\Core\Form\FormBuilderInterface
     */
    protected $formBuilder;

    /**
     * The event dispatcher.
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

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
            $container->get('form_builder'),
            $container->get('event_dispatcher'),
            $container->get('magic_ball.answer_service')
        );
    }

    /**
     * Constructs an MagicController object.
     *
     * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
     *   The form builder.
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
     *   The event dispatcher.
     * @param \Drupal\magic_ball\AnswerService $answerService
     *   The service for answers.
     */
    public function __construct(FormBuilderInterface $form_builder, $event_dispatcher, $answerService) {
        $this->formBuilder = $form_builder;
        $this->eventDispatcher = $event_dispatcher;
        $this->answerService = $answerService;
    }

    /**
     * Shows page with question form.
     * 
     * @return array
     */
    public function showQuestionPage() {

        $config = $this->config('magic_ball.settings');
        $user = $this->currentUser();

        $e = new MagicPageLoadEvent($config, $user);
        
        $this->eventDispatcher->dispatch(MagicEvents::PAGE_LOAD, $e);
        $form = $this->formBuilder->getForm('\Drupal\magic_ball\Form\MagicQuestionForm');

        $output = array(
            'message' => array(
                '#markup' => $this->t('You may ask a question with yes/no type of answer! The magic ball knows a right answer!')
            ),
            'question_form' => array(
                'form' => $form,
            )
        );

        return $output;
    }

    /**
     * Shows page with configuration form.
     *
     * @return array
     */
    public function showConfigurationPage() {

        $list_phrases = $this->answerService->getPhrasesList();
        $form = $this->formBuilder->getForm('\Drupal\magic_ball\Form\MagicConfigForm');

        $output = array(
            'header_phrase' => array(
                '#markup' => '<h2>' . $this->t('List of phrases') . '</h2>',
            ),
            'list_phrases' => array(
                '#markup' => $list_phrases,
            ),
            'add_message' => array(
                '#markup' => '<h2>' . $this->t('Add/change phrase') . '</h2>',
            ),
            'question_form' => array(
                'form' => $form,
            ),
        );

        return $output;
    }
}
