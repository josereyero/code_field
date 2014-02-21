<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField\.
 */

namespace Drupal\d7field\ExtraField;

use Drupal\d7field\FieldDefinitionBase;

abstract class ExtraFieldBase extends FieldDefinitionBase {

  /**
   * Get field informattion.
   */
  public function getDefinition() {
    return parent::getDefinition() + array(
      'weight' => $this->getWeight(),
    );
  }

  /**
   * Get field title.
   *
   * @return string
   */
  public function getTitle() {
    return isset($this->definition['title']) ? $this->definition['title'] : '';
  }

  /**
   * Get field default weight.
   *
   * @return int
   */
  public function getWeight() {
    return isset($this->definition['weight']) ? $this->definition['weight'] : 0;
  }

}
