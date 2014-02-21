<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField\.
 */

namespace Drupal\d7field\ExtraField;

/**
 * Code field with callback function.
 *
 * The field definition must contain a 'callback' function name, that will be
 * invoked passing the element
 */
class ExtraFieldCallback extends ExtraFieldDefinitionBase {
  /**
   * Implements ExtraFieldDefinitionBase::render().
   */
  function render(array $element) {
    return call_user_func($this->info['callback'], $element, $this->definition);
  }
}
