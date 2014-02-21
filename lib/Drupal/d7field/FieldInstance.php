<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldInstance.
 */

namespace Drupal\d7field;

/**
 * Wrap field instances for the rest of the API.
 */
class FieldInstance {
  /**
   * Variables that define a field instance.
   */
  protected $field_name;
  protected $entity_type;
  protected $instance;
  protected $entity;
  /**
   * Cache formatter objects indexed by view mode.
   */
  protected $formatter;

  /**
   * Constructor.
   */
  function __construct($instance, $entity = NULL) {
    $this->instance = $instance;
    $this->entity = $entity;
    foreach (array('entity_type', 'bundle', 'field_name') as $field) {
      $this->$field = $instance[$field];
    }
  }

  /**
   * Get instance array.
   */
  public function getInstance() {
    return $this->instance;
  }
  /**
   * Get entity type.
   */
  public function getEntityType() {
    return $this->entity_type;
  }

  /**
   * Get field type
   */
  public function getFieldInfo() {
    return field_info_field($this->field_name);
  }

  /**
   * Get FieldFormatter for a view mode.
   */
  public function getDisplay($view_mode = 'default') {
    if (isset($this->instance['display'][$view_mode])) {
      return $this->instance['display'][$view_mode];
    }
    else {
      return $this->instance['display']['default'];
    }
  }

  /**
   * Get FieldFormatter for a view mode.
   */
  public function getFormatter($view_mode = 'default') {
    if (!isset($this->formatter[$view_mode])) {
      $display = $this->getDisplay($view_mode);
      if ($display['module'] == 'dxfield') {
        $class = $display['class'];
        $this->formatter[$view_mode] = new $class($display['type'], $display, $view_mode);
      }
      else {
        // Not type of formatter
        $this->formatter[$view_mode] = FALSE;
      }
    }
    return $this->formatter[$view_mode];
  }

}