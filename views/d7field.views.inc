<?php
/**
 * @file
 * Imlements views.inc with hook_views_data. Needed to register the code fields.
 *
 * Based on extrafields_views_integration.views.inc
 */

use Drupal\d7field\ExtraField\ExtraFieldManager;

/**
 * Implements hook_views_data().
 */
function d7field_views_data() {
  $data = array();

  foreach (ExtraFieldManager::getInfo() as $entity_type => $entity_fields) {
    foreach ($entity_fields as $bundle_name => $bundle_fields) {
      if (isset($bundle_fields['display'])) {
        foreach ($bundle_fields['display'] as $field_name => $definition) {
          if (!empty($definition['views']) && $entity_info = entity_get_info($entity_type)) {
            $instance = ExtraFieldManager::getInstance($field_name, $definition);
            $data[$entity_info['base table']][$field_name] = array(
              'title' => $definition['label'],
              'help' => t('Integrate code field: @label for entity type: @entity_type', array(
                '@label' => $definition['label'],
                '@entity_type' => $entity_type,
              )),
              'field' => array(
                'handler' => 'd7field_views_handler_extra_field',
                'click sortable' => FALSE,
                'field name' => $field_name,
                'field definition' => $definition,
              ),
            );
          }

        }
      }
    }
  }

  return $data;
}
