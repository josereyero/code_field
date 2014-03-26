<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldWidget\WidgetManager
 */

namespace Drupal\d7field\FieldWidget;

use \Drupal\d7field\ManagerBase;

class WidgetManager extends ManagerBase {

  public static function getInfo() {
    if (!isset(self::$info['widget'])) {
      self::$info['widget'] = self::buildInfo('d7_field_widget_info');
    }
  }

  /**
   * Implements hook_field_widget_info_alter().
   */
  public static function hook_field_widget_info_alter(&$info) {
    if ($d7info = self::getInfo()) {
      self::extendInfo(array_keys($d7info), $info);
    }
  }

}