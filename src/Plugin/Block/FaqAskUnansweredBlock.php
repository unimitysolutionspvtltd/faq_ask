<?php

/**
 * @file
 * Contains \Drupal\faq_ask\Plugin\Block\FaqCategoriesBlock.
 */

namespace Drupal\faq_ask\Plugin\Block;

use Drupal\Core\Url;
use Drupal\faq_ask\Utility;
use Drupal\Core\Block\BlockBase;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Provides a simple block.
 *
 * @Block(
 *   id = "faq_categories",
 *   admin_label = @Translation("FAQ Categories")
 * )
 */
class FaqAskUnansweredBlock extends BlockBase {

  /**
   * Implements \Drupal\block\BlockBase::blockBuild().
   */
  public function build() {
    return Utility::_faq_ask_list_unanswered(3);
  }

}
