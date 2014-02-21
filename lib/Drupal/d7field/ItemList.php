<?php

/**
 * @file
 * Contains \Drupal\d7field\ItemList.
 *
 * Emulating Drupal 8 \Drupal\Core\TypedData\Plugin\DataType\ItemList
 */

namespace Drupal\d7field;

/**
 * Contains a list of items .
 */
class ItemList implements \ArrayAccess, \Countable, \Traversable {

   /**
   * Numerically indexed array items.
   *
   * @var array
   */
  protected $list = array();

  /**
   * Overrides \Drupal\Core\TypedData\TypedData::getValue().
   */
  public function getValue() {
    if (isset($this->list)) {
      return $this->list;
    }
  }

  /**
   * Overrides \Drupal\Core\TypedData\TypedData::setValue().
   *
   * @param array|null $values
   *   An array of values of the field items, or NULL to unset the field.
   */
  public function setValue($values) {
    $this->list = $values;
  }

  /**
   * {@inheritdoc}
   */
  public function get($index) {
    if (!is_numeric($index)) {
      throw new \InvalidArgumentException('Unable to get a value with a non-numeric delta in a list.');
    }
    // Allow getting not yet existing items as well.
    // @todo: Maybe add a public createItem() method in addition?
    elseif (!isset($this->list[$index])) {
      $this->list[$index] = $this->createItem($index);
    }
    return $this->list[$index];
  }

  /**
   * {@inheritdoc}
   */
  public function set($index, $item) {
    if (is_numeric($index)) {
      $this->list[$index] = $item;
      return $this;
    }
    else {
      throw new \InvalidArgumentException('Unable to set a value with a non-numeric delta in a list.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function first() {
    return $this->get(0);
  }

  /**
   * Implements \ArrayAccess::offsetExists().
   */
  public function offsetExists($offset) {
    return isset($this->list) && array_key_exists($offset, $this->list) && $this->get($offset) !== NULL;
  }

  /**
   * Implements \ArrayAccess::offsetUnset().
   */
  public function offsetUnset($offset) {
    if (isset($this->list)) {
      unset($this->list[$offset]);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function offsetGet($offset) {
    return $this->get($offset);
  }

  /**
   * Implements \ArrayAccess::offsetSet().
   */
  public function offsetSet($offset, $value) {
    if (!isset($offset)) {
      // The [] operator has been used so point at a new entry.
      $offset = $this->list ? max(array_keys($this->list)) + 1 : 0;
    }
    $this->set($offset, $value);
  }

  /**
   * Implements \IteratorAggregate::getIterator().
   */
  public function getIterator() {
    if (isset($this->list)) {
      return new \ArrayIterator($this->list);
    }
    return new \ArrayIterator(array());
  }

  /**
   * Implements \Countable::count().
   */
  public function count() {
    return isset($this->list) ? count($this->list) : 0;
  }

  /**
   * Implements \Drupal\Core\TypedData\ListInterface::isEmpty().
   */
  public function isEmpty() {
    return $this->count() == 0;
  }
}
