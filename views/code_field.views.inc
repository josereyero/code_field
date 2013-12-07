<?php
/**
 * @file
 * Imlements views.inc with hook_views_data. Needed to register the code fields.
 *
 * Based on extrafields_views_integration.views.inc
 */

/**
 * Implements hook_views_data().
 */
function code_field_views_data() {
  $data = array();

  foreach (CodeFieldInfo::getList() as $info) {
    // Get the entityInfo from the code field entitytype to get the base
    // table for views.
    if ($info->views && $entity_info = entity_get_info($info->entity_type)) {
      $code = code_field($info);
      $data[$entity_info['base table']][$info->field_name] = array(
        'title' => $code->getLabel(),
        'help' => t('Integrate code field: @label for entity type: @entity_type', array(
          '@label' => $code->getLabel(),
          '@entity_type' => $info->entity_type,
        )),
        'field' => array(
          'handler' => 'code_field_views_handler_field_entity',
          'click sortable' => FALSE,
          'code_field' => $info,
        ),
      );
    }
  }

  return $data;
}
