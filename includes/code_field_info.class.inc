<?php
/**
 * @file
 * Class CodeFieldInfo
 */

/**
 * Stores field info.
 */
class CodeFieldInfo {

  /**
   * Field info array.
   *
   * @var array
   *   Array of definition objects indexed
   */
  protected static $info;

  /**
   * Get info for all fields.
   */
  public static function getInfo() {
    if (!isset(self::$info)) {
      self::buildInfo();
    }
    return self::$info;
  }

  /**
   * Get info for fields of a given class.
   *
   * @param string $type
   *   Entity type.
   * @param string $bundle
   *   Bundle name.
   *
   * @return array
   *   Array of field definitions for this entity type and bundle.
   */
  public static function getType($type, $bundle) {
    $info = self::getInfo();
    if (isset($info[$type]) && isset($info[$type][$bundle])) {
      return $info[$type][$bundle];
    }
    else {
      return array();
    }
  }

  /**
   * Get list
   *
   * @return array
   *   Plain list of all field definitions.
   */
  public static function getList() {
    $list = array();
    foreach (self::getInfo() as $type => $type_info) {
      foreach ($type_info as $bundle => $bundle_info) {
        foreach ($bundle_info as $name => $info) {
          $list[$type . ':' . $bundle . ':' . $name] = $info;
        }
      }
    }
    return $list;
  }

  /**
   * Build info for all fields.
   */
  protected static function buildInfo() {
    self::$info = array();
    foreach (module_implements('code_field_info') as $module) {
      $function = $module . '_code_field_info';
      if (function_exists($function)) {
        foreach ($function() as $entity_type => $entity_info) {
          foreach ($entity_info as $bundle_name => $bundle_info) {
            foreach ($bundle_info as $field_name => $field_info) {
              // If it has a callback, add our own class.
              if (!isset($field_info['class']) && isset($field_info['callback'])) {
                $field_info['class'] = 'CodeFieldCallback';
              }
              $field_info += array(
                'entity_type' => $entity_type,
                'bundle_name' => $bundle_name,
                'field_name' => $field_name,
                'class' => 'CodeFieldCallback',
                'module' => $module,
                'extra' => FALSE,
                'views' => FALSE,
                'panels' => FALSE,
              );
              self::$info[$entity_type][$bundle_name][$field_name] = (object)$field_info;
            }
          }
        }
      }
    }
  }

}
