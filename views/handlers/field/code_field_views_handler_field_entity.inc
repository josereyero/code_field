<?php
/**
 * @file
 * Implements the field handler class.
 *
 * Based on extrafield_views_integration_handler_field_extrafield.inc
 */

class code_field_views_handler_field_entity extends views_handler_field_entity {

  /**
   * Overrides views_handler_field_entity::render().
   *
   * @param mixed $values
   *   The values retrieved from the database.
   */
  public function render($values) {
    if (($entity = $this->get_value($values))) {
      return code_field($this->definition['code_field'])->views_render($entity, $values, $this);
    }
    else {
      return '';
    }
  }

}
