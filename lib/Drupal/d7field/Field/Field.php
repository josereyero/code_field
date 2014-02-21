<?php

/**
 * @file
 * Contains \Drupal\d7field\Field\Field.
 */

namespace Drupal\d7field\Field;

/**
 * Defines a field type + a field instance.
 */
class Field extends FieldDefinitionBase {

  /**
   * Implements hook_field_settings_form().
   */
  function hook_field_settings_form($field, $instance, $has_data) {

  }

  /**
   * Implements hook_field_instance_settings_form()
   */
  function hook_field_instance_settings_form($field, $instance) {

  }

  /**
   * Implements hook_field_insert()
   */
  function hook_field_insert($entity_type, $entity, $field, $instance, $langcode, &$items) {

  }

  /**
   * Implements hook_field_is_empty().
   */
  function hook_field_is_empty($item, $field) {

  }

  /**
   * Implements hook_field_load().
   */
  function hook_field_load($entity_type, $entities, $field, $instances, $langcode, &$items, $age) {

  }

  /**
   * Implements hook_field_prepare_translation()
   */
  function hook_field_prepare_translation($entity_type, $entity, $field, $instance, $langcode, &$items, $source_entity, $source_langcode) {

  }

  /**
   * Implements hook_field_prepare_view()
   */
  function hook_field_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items) {

  }

  /**
   * Implements hook_field_presave()
   */
  function hook_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {

  }

  /**
   * Implements hook_field_schema()
   */
  function hook_field_schema($field) {

  }

  /**
   * Implements hook_field_presave().
   */
  function hook_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {

  }

  /**
   * Implements hook_field_validate().
   */
  function hook_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {

  }

}
