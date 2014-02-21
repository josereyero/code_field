<?php

/**
 * @file
 * Contains \Drupal\d7field\ExtraField\ExtraFieldDisplay.
 */

namespace Drupal\d7field\ExtraField;

/**
 * Base class for extra field displays with late rendering.
 *
 * Classes extending this one must implement the render() method.
 */
abstract class ExtraFieldRender extends ExtraFieldDisplay {

  /**
   * Implements ExtrafieldDisplay::render().
   */
  public function build(array $element) {
    return $element + array(
      '#type' => 'd7field_extra_field',
      '#name' => $this->name,
      '#instance' => $this,
    );
  }

  /**
   * Render a field's element.
   *
   * @param $element
   *   Element array that may contain an '#entity' element and some other
   *   values depending on the field and the hook invoked.
   *
   * @return string|array
   *   HTML string or renderable array.
   */
  public abstract function render(array $element);

  /**
   * Run the pre_render operation on the element.
   *
   * @param $element
   *   Element array.
   *
   * @return array
   *   Renderable array.
   */
  public function pre_render(array $element) {
    return $element;
  }
}
