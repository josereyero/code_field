<?php

/**
 * @file
 * Contains \Drupal\d7field\ManagerBase.
 */

namespace Drupal\d7field\Extrafield;

use \Drupal\d7field\ManagerBase;

class ExtraFieldManager extends ManagerBase {

  /**
  * Get extra field information from modules.
  */
  public static function getInfo() {
    if (!isset(self::$info['extra'])) {
      $extra = array();
      foreach (module_implements('d7_field_extra_fields') as $module) {
        if ($result = module_invoke($module, 'd7_field_extra_fields')) {
          foreach ($result as $entity_type => &$type_fields) {
            foreach ($type_fields as $bundle_name => &$bundle_fields) {
              foreach ($bundle_fields as $context => &$context_fields) {
                foreach ($context_fields as $name => &$info) {
                  $info += array(
                    'module' => 'd7field',
                    'context' => $context,
                    'base_module' => $module,
                    'entity_type' => $entity_type,
                    'bundle_name' => $bundle_name,
                    'extra' => TRUE,
                    'views' => TRUE,
                  );
                  // Add definition from class.
                  $info += self::getInstance($name, $info)->getDefinition();
                }
              }
            }
          }
          $extra = array_merge_recursive($extra, $result);
        }
      }
      self::$info['extra'] = $extra;
    }
    return self::$info['extra'];
  }

  /**
  * Get extra field instance.
  */
  public static function getInstance($name, $definition) {
    $cache_key = array($definition['entity_type'], $definition['bundle_name'] , $definition['context'], $name);
    return self::buildInstance('extra_field', $name, $definition, $cache_key);
  }

  /**
  * Implements hook_entity_view().
  */
  public static function hook_entity_view($entity, $type, $view_mode, $langcode) {
    list($id, $vid, $bundle) = entity_extract_ids($type, $entity);
    // Build only the fields that are visible.
    $display = field_extra_fields_get_display($type, $bundle, $view_mode);
    foreach (field_info_extra_fields($type, $bundle, 'display') as $name => $definition) {
      if (isset($definition['module']) && $definition['module'] == 'd7field') {
        $entity->content[$name] = self::getInstance($name, $definition)
          ->entity_view($entity, $type, $view_mode, $langcode);
      }
    }
  }

}