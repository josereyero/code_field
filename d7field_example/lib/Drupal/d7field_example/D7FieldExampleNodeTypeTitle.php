<?php
/**
 * @file
 * Example code field classes.
 */

namespace Drupal\d7field_example;

use Drupal\d7field\ExtraField\ExtraFieldRender;

class D7FieldExampleNodeTypeTitle extends ExtraFieldRender {
  /**
   * Implementation of D7FieldDefinitionBase::render().
   */
  public function render(array $element) {
    $node = $element['#entity'];
    return t('Node @type: @title', array(
      '@type' => node_type_get_name($node->type),
      '@title' => $node->title
    ));
  }
}
