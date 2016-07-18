<?php

/**
 * @file
 * Contains \Drupal\faq\Controller\FaqController.
 */

namespace Drupal\faq_ask\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\faq_ask\Utility;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

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
  
  public function askPageSettings() {
    /**
     *
     * Get the ask question form.
     *
     * Obsolete? Doesn not seem to be called anywhere
     *
     * @return void
     */
    return new RedirectResponse(URL::fromUserInput('/node/add/faq?ask=TRUE')->toString());
  }

  /**
 * This function is called when an expert selects a question to answer.
 *
 * It changes the status option to "published" then goes to the regular FAQ edit function.
 *
 * @param object $node
 *     FAQ node to answer
 */
  function askAnswerViewSettings($nid) {
    $faq_ask_settings = \Drupal::config('faq_ask.settings');
    $user = \Drupal::currentUser();
    if ($user->id() == '0') { // If user is not logged in
      $path = URL::fromUserInput('/user', array('query' => drupal_get_destination()))->toString();// Log in first
      return new RedirectResponse($path);
    }
    // Validate the request.
    if (!isset($_REQUEST['token']) || !(Utility::_faq_ask_valid_token($_REQUEST['token'], "faq_ask/answer/". $nid))) {
      \Drupal::logger('Faq_Ask')->error("Received an invalid answer request (@query_string) from @user_ip.", array('@query_string' => $_SERVER['QUERY_STRING'], '@user_ip' => $_SERVER['REMOTE_ADDR']));
      throw new AccessDeniedHttpException();
    }
    $reassign_opt = $faq_ask_settings->get('expert_own');
    // Check if we need to reassign to the expert.
    switch ($reassign_opt) {
      case 0:  // Do not reassign.
        break;
  
      case 1:  // Reassign if anonymous.
        if ($node->uid == 0) {
          Utility::faq_ask_reassign($node);
        }
        break;
  
      case 2:  // Always reassign.
        Utility::faq_ask_reassign($node);
        break;
    }
  
    // Change the status to published
    $node = node_load($nid);
    $node->status->value = 1;
    $node->save();
  
    // Need to invoke node/##/edit.
    return new RedirectResponse(URL::fromUserInput('/node/'. $nid . '/edit')->toString());
  }
  
  public function askAnswerEditSettings($nid) {
    // Node Object
    $node = node_load($nid);
    if ($node->get('status')->value == 1) {
      drupal_set_message($this->t('That question has already been answered.'), 'status');
    }
    else {
      if (node_access('update', $node)) {
        $path = URL::fromUserInput('/node/' . $node->get('nid')->value . '/edit', array('query' => array( 'ask' => 'TRUE' )))->toString();// Log in first
        return new RedirectResponse($path);
      }
      else {
      drupal_set_message($this->t('You are not allowed to edit that question.'), 'error');
      }
    }
    return new RedirectResponse(URL::fromUserInput('/node')->toString());
  }
  
  /**
    *  This function lists all the unanswered questions the user is allowed to see.
    *  It is used by the "more..." link from the block, but can also be called independently.
    */
   public function askUnanswerSettings() {
      $build['#markup'] = Utility::_faq_ask_list_unanswered(9999999);
      return $build;
   }
}
