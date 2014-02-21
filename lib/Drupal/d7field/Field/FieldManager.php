<?php



namespace Drupal\d7field\Field;

use \Drupal\d7field\ManagerBase;

/**
 * Manages field type information
 */
class FieldManager extends ManagerBase {

  /**
   * Get field type information.
   */
  public static function getInfo() {
    if (!isset(self::$info['type'])) {
      self::$info['type'] = self::buildInfo('d7_field_info');
    }
    return self::$info['type'];
  }

  /**
   * Implements hook_field_info_alter()
   */
  public static function hook_field_info_alter(&$info) {
    self::extendInfo(array_keys(self::getInfo()), $info);
  }

  /**
   * Get field instance object.
   */
  static function getField($field, $instance = NULL) {
    $cache_keys = array($definition['field_name'], $instance ? $instance['id'] : 0);
    $field = self::buildInstance('field', $definition['field_name'], $definition, $cache_keys);
    $field->setInstance($instance);
    return $formatter;
  }

  /**
   * Implements hook_field_settings_form().
   */
  static function hook_field_settings_form($field, $instance, $has_data) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_settings_form($field, $instance, $has_data);
    }
  }

  /**
   * Implements hook_field_instance_settings_form()
   */
  static function hook_field_instance_settings_form($field, $instance) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_instance_settings_form($field, $instance);
    }
  }

  /**
   * Implements hook_field_insert()
   */
  static function hook_field_insert($entity_type, $entity, $field, $instance, $langcode, &$items) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_insert($entity_type, $entity, $field, $instance, $langcode, $items);
    }
  }

  /**
   * Implements hook_field_is_empty().
   */
  static function hook_field_is_empty($item, $field) {
    $object = self::getField($field);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_is_empty($item, $field);
    }
  }

  /**
   * Implements hook_field_load().
   */
  static function hook_field_load($entity_type, $entities, $field, $instances, $langcode, &$items, $age) {
    $object = self::getField($field);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_load($entity_type, $entities, $field, $instances, $langcode, $items, $age);
    }
  }

  /**
   * Implements hook_field_prepare_translation()
   */
  static function hook_field_prepare_translation($entity_type, $entity, $field, $instance, $langcode, &$items, $source_entity, $source_langcode) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_prepare_translation($entity_type, $entity, $field, $instance, $langcode, $items, $source_entity, $source_langcode);
    }
  }

  /**
   * Implements hook_field_prepare_view()
   */
  static function hook_field_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_prepare_view($entity_type, $entities, $field, $instances, $langcode, $items);
    }
  }

  /**
   * Implements hook_field_presave()
   */
  static function hook_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_presave($entity_type, $entity, $field, $instance, $langcode, $items);
    }
  }

  /**
   * Implements hook_field_schema()
   */
  static function hook_field_schema($field) {
    $object = self::getField($field);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_schema($field);
    }
  }

  /**
   * Implements hook_field_storage_update_field()
   */
  static function hook_field_storage_update_field($field, $prior_field, $has_data) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_storage_update_field($field, $prior_field, $has_data);
    }
  }

  /**
   * Implements hook_field_update()
   */
  static function hook_field_update($entity_type, $entity, $field, $instance, $langcode, &$items) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_update($entity_type, $entity, $field, $instance, $langcode, &$items);
    }
  }

  /**
   * Implements hook_field_validate().
   */
  static function hook_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {
    $object = self::getField($field, $instance);
    if (method_exists($object, __FUNCTION__)) {
      return $object->hook_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, $errors);
    }
  }

}
