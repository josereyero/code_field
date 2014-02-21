<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldInfo.
 */

namespace Drupal\d7field;

use Drupal\d7field\InstanceDefinitionBase;

abstract class ExtenderBase extends InstanceDefinitionBase {


  /**
   * Get function from base module and check existence.
   */
  protected function baseFunction($hook) {
    $function = $this->definition['extend module'] . substr($hook, 4);
    return function_exists($function) ? $function : NULL;
  }

  /**
   * Invoke function from base module with value parameters.
   */
  protected function baseInvoke($hook, $args) {
    if ($function = $this->baseFunction($hook)) {
      return call_user_func_array($function, $args);
    }
  }
}
