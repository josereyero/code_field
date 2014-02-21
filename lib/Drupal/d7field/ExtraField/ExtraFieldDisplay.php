<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField\ExtraFieldDisplay.
 */

namespace Drupal\d7field\ExtraField;

/**
 * Base class for extra field displays.
 *
 * Classes extending this one must implement the build() method.
 */
abstract class ExtraFieldDisplay extends ExtraFieldBase {

  /**
   * Build the field on entity_view().
   */
  public function entity_view($entity, $type, $view_mode, $langcode) {
    return $this->build(array(
      '#entity' => $entity,
      '#langcode' => $langcode,
    ));
  }

  /**
   * Build the field on views_render().
   */
  public function views_render($definition, $entity, $values, $handler) {
    return $this->build(array(
      '#entity' => $entity,
      '#langcode' => NULL,
    ));
  }

  /**
   * Build element array to be rendered later.
   *
   * @param array $element
   *   Base element array with at least '#entity' element
   */
  public abstract function build(array $element);

}
