<?php

/**
 * @file
 * Contains \Drupal\faq_ask\Plugin\Block\FaqCategoriesBlock.
 */

namespace Drupal\faq_ask\Plugin\Block;

use Drupal\faq_ask\Utility;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a simple block.
 *
 * @Block(
 *   id = "faq_ask_question",
 *   admin_label = @Translation("FAQ Ask Questions")
 * )
 */
class FaqAskQuestionBlock extends BlockBase {

  /**
   * Implements \Drupal\block\BlockBase::blockBuild().
   */
  public function build() {
    //Utility::faq_ask_a_question_blockform();
   return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }
  

}
