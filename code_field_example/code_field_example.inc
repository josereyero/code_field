<?php
/**
 * @file
 * Example code field classes.
 */

class CodeFieldExampleNodeTypeTitle extends CodeFieldRender {
  /**
   * Implementation of CodeFieldBase::render().
   */
  public function render(array $element) {
    $node = $element['#entity'];
    return t('Node @type: @title', array(
      '@type' => node_type_get_name($node->type),
      '@title' => $node->title
    ));
  }
}

class CodeFieldExampleUserHello extends CodeFieldRender {
  /**
   * Implementation of CodeFieldBase::render().
   */
  public function render(array $element) {
    $user = $element['#entity'];
    return t('Hello @name, how are you?', array('@name' => $user->name));
  }
}