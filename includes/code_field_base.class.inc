<?php

/**
 * Base classes for code fields.
 */
abstract class CodeFieldBase {

  /**
   * Field info object.
   *
   * @var object
   */
  protected $info;

  /**
   * Constructor.
   *
   * @param string $class
   *   Class name.
   */
  public function __construct($info) {
    $this->info = $info;
  }

  /**
   * Get field label.
   *
   * @return string
   */
  public function getLabel() {
    return isset($this->info->label) ? $this->info->label : t('Code Field: @class', array('@class' => get_called_class()));
  }

  /**
   * Get field title.
   *
   * @return string
   */
  public function getTitle() {
    return isset($this->info->title) ? $this->info->title : '';
  }

  /**
   * Get field description.
   *
   * @return string
   */
  public function getDescription() {
    return isset($this->info->description) ? $this->info->description : '';
  }

  /**
   * Get field default weight.
   *
   * @return int
   */
  public function getWeight() {
    return isset($this->info->weight) ? $this->info->weight : 0;
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
   * Build field as a renderable array.
   *
   * @param $element
   *   Element array.
   *
   * @return array
   *   Renderable array.
   */
  public function build(array $element) {
    $render = $this->render($element);
    return is_array($render) ? $render : array('#markup' => (string)$render);
  }

  /**
   * Attach field to entity, invoked from hook_entity_view().
   *
   * Override only if you need more than adding a field to the entity.
   *
   * @param object $entity
   *   Entity to be rendered.
   * @param string $view_mode
   *   Entity view mode
   * @param string $langcode
   *   Language code.
   */
  public function entity_view($entity, $view_mode, $langcode) {
    $entity->content[$this->info->field_name] = $this->build(array(
      '#entity' => $entity,
      '#view_mode' => $view_mode,
      '#langcode' => $langcode,
    ));
  }

  /**
   * Render views field, invoked from field handler.
   *
   * Override only if you need more than rendering a views field.
   *
   * @param object $entity
   *   Entity to be rendered.
   * @param object $values
   *   Field values.
   * @param code_field_views_handler_field_entity $handler
   *   Views field handler
   *
   * @return string|array
   *   String or renderable array.
   */
  public function views_render($entity, $values, $handler) {
    return $this->build(array(
      '#entity' => $entity,
    ));
  }
}

/**
 * Code field with callback function.
 *
 * The field definition must contain a 'callback' function name, that will be
 * invoked passing the element
 */
class CodeFieldCallback extends CodeFieldBase {
  /**
   * Implements CodeFieldBase::render().
   */
  function render(array $element) {
    return call_user_func($this->info['callback'], $element, $this->info);
  }
}

/**
 * Code field with support for late rendering.
 *
 * Instead of a straight renderable array, these fields build an element
 * with type 'code_field'. The pre-render callback of these elements will
 * invoke the 'pre_render' method of the object.
 *
 * This may be useful for performance reasons because many of the fields
 * added, specially on 'entity_view' like hooks are not eventually rendered.
 */
abstract class CodeFieldRender extends CodeFieldBase {

  /**
   * Overrides CodeField::build()
   */
  public function build($element = array()) {
    return $element + array(
      '#type' => 'code_field',
      '#code_field' => $this,
    );
  }

  /**
   * Pre-render element.
   */
  public function pre_render($element) {
    $render = static::render($element);
    if (is_array($render)) {
      // It is a renderable array, return as is.
      return $render + $element;
    }
    else {
      // Rendered HTML, build a renderable element.
      return array(
        '#type' => 'markup',
        '#children' => (string)$render,
      ) + $element;
    }
  }
}



