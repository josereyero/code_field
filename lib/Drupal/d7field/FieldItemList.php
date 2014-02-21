<?php

/**
 * @file
 * Contains \Drupal\d7field\ItemList.
 *
 * Emulating Drupal 8 \Drupal\Core\TypedData\Plugin\DataType\FieldItemList
 */

namespace Drupal\d7field;

/**
 * Contains a list of items belonging to an entity field.
 */
class FieldItemList extends ItemList {

  /**
   * Entity context.
   */
  protected $entity_type;
  protected $entity;
  protected $field_instance;

  /**
   * Display context.
   */
  protected $langcode;
  protected $delta = 0;

  /**
   * Construct from entity $items array.
   */
  public function __construct(&$items, $entity_type, $entity, $field_instance, $langcode = NULL, $delta = NULL) {
    $this->list = &$items;
    $this->entity_type = $entity_type;
    $this->entity = $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Entity type.
   */
  public function getEntityType() {
    return $this->entity_type;
  }

  /**
   * {@inheritdoc}
   */
  public function setLangcode($langcode) {
    $this->langcode = $langcode;
  }

  /**
   * {@inheritdoc}
   */
  public function getLangcode() {
    return $this->langcode;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldDefinition() {
    return $this->field_instance;
  }

 /**
   * {@inheritdoc}
   */
  public function filterEmptyItems() {
    if (isset($this->list)) {
      $this->list = array_values(array_filter($this->list, function($item) {
        is_empty($item);
      }));
    }
  }

 /**
   * {@inheritdoc}
   */
  public function __get($property_name) {
    return $this->first()->__get($property_name);
  }

  /**
   * {@inheritdoc}
   */
  public function __set($property_name, $value) {
    $this->first()->__set($property_name, $value);
  }

  /**
   * {@inheritdoc}
   */
  public function __isset($property_name) {
    return $this->first()->__isset($property_name);
  }

  /**
   * {@inheritdoc}
   */
  public function __unset($property_name) {
    return $this->first()->__unset($property_name);
  }

}