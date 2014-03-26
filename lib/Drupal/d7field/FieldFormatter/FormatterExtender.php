<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldFormatter\FormatterExtender
 */

namespace Drupal\d7field\FieldFormatter;

use Drupal\d7field\ExtenderBase;

/**
 * Wrap an existing formatter.
 */
class FormatterExtender extends ExtenderBase implements FormatterInterface {
  /**
   * Implements hook_field_formatter_prepare_view().
   */
  function hook_field_formatter_prepare_view($entity_type, $entities, $field, $instances, $langcode, &$items, $displays) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      $displays = array_map(array($this, 'baseDisplay'), $displays);
      $function($entity_type, $entities, $field, $instances, $langcode, $items, $displays);
    }
  }

  /**
   * Implements hook_field_formatter_settings_form().
   */
  function hook_field_formatter_settings_form($field, $instance, $view_mode, $form, &$form_state) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      $instance['display'][$view_mode] = $this->baseDisplay($instance['display'][$view_mode]);
      return $function($field, $instance, $view_mode, $form, $form_state);;
    }
    else {
      return array();
    }
  }

  /**
   * Implements hook_field_formatter_settings_summary().
   */
  function hook_field_formatter_settings_summary($field, $instance, $view_mode) {
    if ($function = $this->baseFunction(__FUNCTION__)) {
      $instance['display'][$view_mode] = $this->baseDisplay($instance['display'][$view_mode]);
      return $function($field, $instance, $view_mode);
    }
  }

  /**
   * Implements hook_field_formatter_view().
   */
 function hook_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
   if ($function = $this->baseFunction(__FUNCTION__)) {
      $display = $this->baseDisplay($display);
      return $function($entity_type, $entity, $field, $instance, $langcode, $items, $this->baseDisplay($display));
    }
  }

  /**
   * Replace module and formatter name.
   */
  public function baseDisplay($display) {
    $display['module'] = $this->definition['extend module'];
    $display['type'] = $this->definition['extend type'];
    return $display;
  }

}
