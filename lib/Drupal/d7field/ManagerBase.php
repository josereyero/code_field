<?php

/**
 * @file
 * Contains \Drupal\d7field\ManagerBase.
 */

namespace Drupal\d7field;

/**
 * Handles field info hooks.
 */
class ManagerBase {

  /**
   * Field info array.
   *
   * @var array
   *   Array of definition objects indexed
   */
  protected static $info;

  /**
   * Statically cached instances.
   *
   * @var instance
   */
  protected static $instance;

  /**
   * Build instance that may be cached.
   */
  public static function buildInstance($type, $name, $definition, $cache_key = NULL) {
    // Cache key will default to name and may be an array.
    $cache_key = isset($cache_key) ? $cache_key : $name;
    $cache_key = is_array($cache_key) ? implode('/', $cache_key) : $cache_key;

    if (!isset(self::$instance[$type][$cache_key])) {
      self::$instance[$type][$cache_key] = self::CreateInstance($name, $definition);
    }
    return self::$instance[$type][$cache_key];
  }

  /**
   * Create instance using definition.
   */
  public static function createInstance($name, $definition) {
    $class = $definition['class'];
    return new $class($name, $definition);
  }

  /**
   * Build info for all fields adding 'base module'.
   */
  protected static function buildInfo($hook) {
    $info = array();
    foreach (module_implements($hook) as $module) {
      $field_types = (array) module_invoke($module, $hook);
      foreach ($field_types as $name => $field_info) {
        $info[$name] = $field_info;
        $info[$name]['base module'] = $module;
        //$info[$name] += self::getInfoDefinition($info);
      }
    }
    return $info;
  }

  /**
   * Extend info for all types.
   *
   * For types defining an 'extend type' property, add the values
   * and the module name from the base type,
   */
  protected static function extendInfo($types, &$info) {
    foreach ($types as $name) {
      if (isset($info[$name]['extend type'])) {
        $extend = $info[$name]['extend type'];
        if (isset($info[$extend])) {
          $info[$name] += $info[$extend];
          $info[$name]['extend module'] = $info[$extend]['module'];
          // Merge settings too.
          if (isset($info[$extend]['settings'])) {
            $info[$name]['settings'] += $info[$extend]['settings'];
          }
        }
        else {
          // Extended type doesn't exist.
          unset($info[$name]);
        }
      }
    }
  }

  /**
   * Get class info.
   */
  protected static function getInfoDefinition($info) {
    return call_user_func(array($info['class'], 'getDefinition'));
  }
}
