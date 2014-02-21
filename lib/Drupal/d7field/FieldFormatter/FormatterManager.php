<?php



namespace Drupal\d7field\FieldFormatter;

use \Drupal\d7field\ManagerBase;

class FormatterManager extends ManagerBase {

  /**
   * Get information about field formatter.
   */
  public static function getInfo() {
    if (!isset(self::$info['formatter'])) {
      self::$info['formatter'] = self::buildInfo('d7_field_formatter_info');
    }
    return self::$info['formatter'];
  }

  /**
   * Implements hook_field_formatter_info_alter().
   */
  public static function hook_field_formatter_info_alter(&$info) {
    self::extendInfo(array_keys(self::getInfo()), $info);
  }

  /**
   * Get formatter object.
   */
  public static function getFormatter($definition, $instance) {
    $formatter = self::buildInstance('formatter', $definition['type'], $definition, array($definition['type'], $instance['id']));
    //$formatter->setInstance($instance);
    return $formatter;
  }

  /**
   * Implements hook_field_formatter_prepare_view().
   */
  public static function hook_field_formatter_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items, $displays) {
    // Group by instance and display type, and then invoke each formatter class
    $invoke = array();
    foreach ($entities as $id => $entity) {
      $display = $displays[$id];
      $instance = $instances[$id];
      $invoke[$instance['id']][$display['type']]['instances'][$id] = $instance;
      $invoke[$instance['id']][$display['type']]['displays'][$id] = $display;
      $invoke[$instance['id']][$display['type']]['entities'][$id] = $entity;
      // Store items by reference so they are passed to the right method.
      $invoke[$instance['id']][$display['type']]['items'][$id] = &$items[$id];
    }

    foreach ($invoke as $invoke_instance) {
      foreach ($invoke_instance as $data) {
        $instance = reset($data['instances']);
        $display = reset($data['displays']);
        $formatter = static::getDisplayFormatter($display, $instance)
          ->hook_field_formatter_prepare_view($entity_type, $data['entities'], $field, $data['instances'], $langcode, $data['items'], $data['displays']);
      }
    }
  }

  /**
   * Implements hook_field_formatter_settings_form().
   */
  public static function hook_field_formatter_settings_form($field, $instance, $view_mode, $form, &$form_state) {
    $object = static::getInstanceFormatter($instance, $view_mode);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_formatter_settings_form($field, $instance, $view_mode, $form, $form_state);
    }
  }

  /**
   * Implements hook_field_formatter_settings_summary().
   */
  public static function hook_field_formatter_settings_summary($field, $instance, $view_mode) {
    $object = static::getInstanceFormatter($instance, $view_mode);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_formatter_settings_summary($field, $instance, $view_mode);
    }
  }

  /**
   * Implements hook_field_formatter_view().
   */
  public static function hook_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
    // This method must exist.
    return static::getDisplayFormatter($display, $instance)
      ->hook_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display);
  }


  /**
   * Get definition from field instance and view mode.
   */
  protected static function getInstanceDisplay($instance, $view_mode) {
    if (isset($instance['display'][$view_mode])) {
      return $instance['display'][$view_mode];
    }
    else {
      return $instance['display']['default'];
    }
  }

  protected static function getDisplayFormatter($display, $instance) {
    $definition = field_info_formatter_types($display['type']);
    $definition['settings'] = $display['settings'];
    $formatter = static::getFormatter($definition, $instance);
    return $formatter;
  }

  /**
   * Get Formatter from field instance and view mode.
   */
  protected static function getInstanceFormatter($instance, $view_mode) {
    $display = static::getInstanceDisplay($instance, $view_mode);
    return static::getDisplayFormatter($display, $instance);
  }


}
