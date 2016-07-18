<?php

/**
 * @file
 * Contains \Drupal\faq_ask\Plugin\Block\FaqAskUnansweredBlock.
 */

namespace Drupal\faq_ask\Plugin\Block;

use Drupal\faq_ask\Utility;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a simple block.
 *
 * @Block(
 *   id = "faq_ask_unanswered",
 *   admin_label = @Translation("FAQ Unanswered Question")
 * )
 */
class FaqAskUnansweredBlock extends BlockBase {

  /**
   * Implements \Drupal\block\BlockBase::blockBuild().
   */
  public function build() {
    //return ;
    return array(
      '#markup' => Utility::_faq_ask_list_unanswered(10),
    );
  }

}
