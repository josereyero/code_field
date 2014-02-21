<?php
/**
 * @file
 * Implements the field handler class.
 *
 * Based on extrafield_views_integration_handler_field_extrafield.inc
 */

use \Drupal\d7field\Extrafield\ExtraFieldManager;

class d7field_views_handler_extra_field extends views_handler_field_entity {

  /**
   * Overrides views_handler_field_entity::render().
   *
   * @param mixed $values
   *   The values retrieved from the database.
   */
  public function render($values) {
    $entity = $this->get_value($values);
    $name = $this->definition['field name'];
    $definition = $this->definition['field definition'];
    return ExtraFieldManager::getInstance($name, $definition)
      ->views_render($this->definition, $entity, $values, $handler);
  }

}
