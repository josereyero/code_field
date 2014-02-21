<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField.
 */

namespace Drupal\d7field\FieldFormatter;


/**
 * Minimum set of methods to implement.
 */
interface FormatterInterface {
  /**
   * Implements hook_field_formatter_view().
   */
  public function hook_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display);

}