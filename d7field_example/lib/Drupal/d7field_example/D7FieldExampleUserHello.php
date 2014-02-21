<?php
/**
 * @file
 * Example code field classes.
 */

namespace Drupal\d7field_example;

use Drupal\d7field\ExtraField\ExtraFieldRender;

class D7FieldExampleUserHello extends ExtraFieldRender {
  /**
   * Implementation of D7FieldDefinitionBase::render().
   */
  public function render(array $element) {
    $user = $element['#entity'];
    return t('Hello @name, how are you?', array('@name' => $user->name));
  }
}