<?php

/**
 * @file
 * Contains \Drupal\faq\Form\ExpertsForm.
 */

namespace Drupal\faq_ask\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for the FAQ settings page - categories tab.
 */
class ExpertsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'faq_experts_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $faq_ask_settings = $this->config('faq_ask.settings');

    $form['faq_ask'] = array(
      '#type' => 'details',
      '#title' => $this->t('FAQ Ask Configuration -Temp'),
      '#open' => TRUE
    );
    
    $form['faq_ask']['enable_faq_ask'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable FAQ Ask'),
      '#description' => $this->t('If this box is checked,  FAQ Ask functionalty get enabled. Note: This a temporary check box.'),
      '#default_value' => $faq_ask_settings->get('enable_faq_ask')
    );
    
    $form['notifications'] = array(
      '#type' => 'details',
      '#title' => $this->t('Notifications'),
      '#open' => TRUE
    );

    $form['notifications']['notify_experts'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Notify experts'),
      '#description' => $this->t('If this box is checked, the expert(s) for the question will be notified via email that a question awaits them. If you do not choose this option, the "Unanswered Questions" block will be the only way they will know they have questions to answer.'),
      '#default_value' => $faq_ask_settings->get('notify_experts')
    );
    
    $form['notifications']['asker_notifications'] = array(
      '#type' => 'details',
      '#title' => $this->t('Asker notification'),
      '#open' => TRUE
    );
    
    $form['notifications']['asker_notifications']['notify_askers'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Notify askers'),
      '#description' => $this->t('If this box is checked, the asker creating the question will be notified via email that their question is answered.'),
      '#default_value' => $faq_ask_settings->get('notify_askers')
    );
    
    $form['notifications']['asker_notifications']['use_cron_notify_askers'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Use cron for asker notification'),
      '#description' => $this->t('If this box is checked, the asker creating the question will be notified via email that their question is answered.'),
      '#default_value' => $faq_ask_settings->get('use_cron_notify_askers')
    );

	
	 $form['option'] = array(
      '#type' => 'details',
      '#title' => $this->t('OPTIONS'),
      '#open' => TRUE
    );
	
	$form['option']['advice_for_admin'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Advice for an administrator/editor'),
      '#description' => $this->t(''),
      '#default_value' => $faq_ask_settings->get('advice_for_experts')
    );
	
	$form['option']['advice_for_asker'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Advice for an asker'),
      '#description' => $this->t(''),
      '#default_value' => $faq_ask_settings->get('advice_for_asker')
    );
	
	 $form['option']['only_expert_categorize'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Only expert can categorize'),
      '#description' => $this->t('If this box is checked, only an expert answering a question can add a category'),
      '#default_value' => $faq_ask_settings->get('only_expert_categorize')
    );
	
	$form['option']['ownership_to_expert'] = array(
	  '#type' => 'radios',
	  '#title' => $this->t('Give ownership to the expert'),
	  '#default_value' => 0,
	  '#description' => $this->t('This determines if questions will be reassigned to the expert when answered.'),
	  '#options' => array(
	  0 => $this->t('Asker retains ownerhsip'), 
	  1 => $this->t('Anonymous questions reassigned to expert'),
	  2 => $this->t('All questions reassigned to expert'))
	);
	
	$form['option']['unanswered_body_text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Default unanswered body text'),
      '#description' => $this->t('
This text will be inserted into the body of questions when they are asked. This helps make editing easier'),
      '#default_value' => $faq_ask_settings->get('unanswered_body_text')
    );
	
	$form['option']['answer_advice_expert'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Answer advice for the expert'),
      '#description' => $this->t('This text will be shown at the bottom of the "Unanswered questions" block.'),
      '#default_value' => $faq_ask_settings->get('answer_advice_expert')
    );
	
	$form['option']['help_text_asker'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Help text for the asker'),
      '#description' => $this->t('This text will be shown at the top of the "Ask a Question" page.'),
      '#default_value' => $faq_ask_settings->get('help_text_asker')
    );
    
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Remove unnecessary values.
    $form_state->cleanValues();

    $this->configFactory()->getEditable('faq_ask.settings')
      ->set('enable_faq_ask', $form_state->getValue('enable_faq_ask'))
      ->set('notify_experts', $form_state->getValue('notify_experts'))
      ->set('notify_askers', $form_state->getValue('notify_askers'))
      ->set('use_cron_notify_askers', $form_state->getValue('use_cron_notify_askers'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
