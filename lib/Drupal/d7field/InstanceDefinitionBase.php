<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldInfo.
 */

namespace Drupal\d7field;

abstract class InstanceDefinitionBase extends FieldDefinitionBase {
  /**
   * Field instance
   */
  protected $instance;

  /**
   * Constructor.
   *
   * @param string $class
   *   Class name.
   */
  public function __construct($name, $definition, $instance = NULL) {
    parent::__construct($name, $definition);
    $this->setInstance($instance);
  }

  /**
   * Set field instance.
   *
   * @param array $instance
   */
  public function setInstance($instance) {
    $this->instance = $instance;
  }

  /**
   * Get field instance.
   */
  public function getInstance() {
    return $this->instance;
  }
}