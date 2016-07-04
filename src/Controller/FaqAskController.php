<?php

/**
 * @file
 * Contains \Drupal\faq\Controller\FaqController.
 */

namespace Drupal\faq_ask\Controller;

use Drupal\faq\Controller;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Query\Condition;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller routines for FAQ Ask routes.
 */
class FaqAskController extends ControllerBase {

  /**
   * Renders the form for the FAQ ASK Settings page - Experts tab.
   *
   * @return
   *   The form code inside the $build array.
   */
  public function expertsSettings() {
    $build = array();
    $build['faq_experts_settings_form'] = $this->formBuilder()->getForm('Drupal\faq_ask\Form\ExpertsForm');

    return $build;
  }

}
