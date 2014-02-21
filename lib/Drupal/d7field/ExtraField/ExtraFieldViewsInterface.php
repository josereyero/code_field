<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField.
 */

namespace Drupal\d7field;

interface ExtraFieldViewsInterface {

  /**
   * Render views field, invoked from field handler.
   *
   * Override only if you need more than rendering a views field.
   *
   * @param object $entity
   *   Entity to be rendered.
   * @param object $values
   *   Field values.
   * @param d7field_views_handler_field_entity $handler
   *   Views field handler
   *
   * @return string|array
   *   String or renderable array.
   */
  public function views_render($entity, $values, $handler);

}