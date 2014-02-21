<?php

/**
 * @file
 * Contains \Drupal\d7field\FieldDefinitionBase
 */

namespace Drupal\d7field;

abstract class FieldDefinitionBase {

  /**
   * Field name.
   *
   * @var string
   */
  protected $name;

  /**
   * Field definition array.
   *
   * @var array
   */
  protected $definition;

  /**
   * The plugin settings.
   *
   * @var array
   */
  protected $settings = array();

  /**
   * Constructor.
   *
   * @param string $class
   *   Class name.
   */
  public function __construct($name, $definition) {
    $this->name = $name;
    $this->setDefinition($definition);
  }

  /**
   * Get field name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get field label.
   */
  public function getLabel() {
    return isset($this->definition['label']) ? $this->definition['label'] : t('Field !class', array('!class' => get_called_class()));
  }

  /**
   * Get field informattion.
   */
  public function getDefinition() {
    return $this->definition + array(
      'label' => $this->getLabel(),
    );
  }

  /**
   * Set definition.
   */
  public function setDefinition($definition) {
    $this->definition = $definition;
    $this->settings = isset($definition['settings']) ? $definition['settings'] : array();
    return $this;
  }

  /**
   * Implements Drupal\field\Plugin\PluginSettingsInterface::getSettings().
   */
  public function getSettings() {
    return $this->settings;
  }

  /**
   * Implements Drupal\field\Plugin\PluginSettingsInterface::getSetting().
   */
  public function getSetting($key) {
    return isset($this->settings[$key]) ? $this->settings[$key] : NULL;
  }

}
