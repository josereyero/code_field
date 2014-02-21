<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField.
 */

namespace Drupal\d7field\FieldFormatter;

use Drupal\d7field\InstanceDefinitionBase;
use Drupal\d7field\FieldItemList;

class FormatterBase extends InstanceDefinitionBase {

  /**
   * @var string
   */
  protected $instance;

  /**
   * Implements hook_field_formatter_settings_form().
   */
  public function hook_field_formatter_settings_form($field, $instance, $view_mode, $form, &$form_state) {
    return $this->settingsForm($form, &$form_state);
  }

  /**
   * Implements hook_field_formatter_settings_summary().
   */
  public function hook_field_formatter_settings_summary($field, $instance, $view_mode) {
    return $this->settingsSummary();
  }

   /**
   * Implements hook_field_formatter_prepare_view().
   */
  public function hook_field_formatter_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items, $displays) {
    $entities_items = array();
    foreach ($items as $id => &$entity_items) {
      $entities_items[$id] = new FieldItemList($entity_items, $entity_type, $entities[$id], $instances[$id], $langcode);
    }
    $this->prepareView($entities_items);
  }

  /**
   * Implements hook_field_formatter_view().
   */
  public function hook_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
    $this->setDefinition($display);
    $items = new FieldItemList($items, $entity_type, $entity, $instance);
    $items->setLangcode($langcode);
    return $this->view($items);
  }

  /**
   * Prepare items to be viewed.
   */
  public function prepareView($entities_items) {
    // Empty implementation.
  }

  /**
   * Implements hook_field_formatter_settings_form().
   */
  public function settingsForm($form, &$form_state) {
    return array();
  }

  /**
   * Implements hook_field_formatter_settings_summary().
   */
  public function settingsSummary() {
    return '';
  }

  /**
   * This is where we do the format.
   */
  public abstract function view(FieldItemList $items);

}