<?php

/**
 * @file
 * Contains \Drupal\d7field\Field\Field.
 */

namespace Drupal\d7field\Field;

use Drupal\d7field\InstanceDefinitionBase;
use Drupal\d7field\ExtenderBase;

/**
 * Extends an existing field type. Any of the hooks can be overridden.
 */
class FieldExtender extends ExtenderBase implements Drupal7FieldInterface {

  /**
   * Implements hook_field_settings_form().
   */
  function hook_field_settings_form($field, $instance, $has_data) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function(self::baseField($field), self::baseField($instance), $has_data);
    }
  }

  /**
   * Implements hook_field_instance_settings_form()
   */
  function hook_field_instance_settings_form($field, $instance) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function(self::baseField($field), $instance);
    }
  }

  /**
   * Implements hook_field_insert()
   */
  function hook_field_insert($entity_type, $entity, $field, $instance, $langcode, &$items) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items);
    }
  }

  /**
   * Implements hook_field_is_empty().
   */
  function hook_field_is_empty($item, $field) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($item, self::baseField($field));
    }
  }

  /**
   * Implements hook_field_load().
   */
  function hook_field_load($entity_type, $entities, $field, $instances, $langcode, &$items, $age) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      $instances = array_map($instances, array($this, 'baseField'));
      return $function($entity_type, $entities, self::baseField($field), $instances, $langcode, &$items, $age);
    }
  }

  /**
   * Implements hook_field_prepare_translation()
   */
  function hook_field_prepare_translation($entity_type, $entity, $field, $instance, $langcode, &$items, $source_entity, $source_langcode) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items, $source_entity, $source_langcode);
    }
  }

  /**
   * Implements hook_field_prepare_view()
   */
  function hook_field_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      $instances = array_map($instances, array($this, 'baseField'));
      return $function($entity_type, $entities, self::baseField($field), $instances, $langcode, $items);
    }
  }

  /**
   * Implements hook_field_presave()
   */
  function hook_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items);
    }
  }

  /**
   * Implements hook_field_schema()
   */
  function hook_field_schema($field) {
    module_load_install($this->definition['base module']);
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function(self::baseField($field));
    }
  }

  /**
   * Implements hook_field_presave().
   */
  function hook_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items);
    }
  }

  /**
   * Implements hook_field_storage_update_field()
   */
  function hook_field_storage_update_field($field, $prior_field, $has_data) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function(self::baseField($field), $prior_field, $has_data);
    }
  }

  /**
   * Implements hook_field_update()
   */
  function hook_field_update($entity_type, $entity, $field, $instance, $langcode, &$items) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items);
    }
  }
  /**
   * Implements hook_field_validate().
   */
  function hook_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      return $function($entity_type, $entity, self::baseField($field), self::baseField($instance), $langcode, $items, $errors);
    }
  }

  /**
   * Get base field with name replaced.
   */
  public function baseField($field) {
    $field['module'] = $this->definition['base module'];
    $field['field_name'] = $this->definition['base name'];
    return $field;
  }
}
