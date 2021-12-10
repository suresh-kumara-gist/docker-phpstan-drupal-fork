<?php

namespace Drupal\some_module;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\some_module\Whatever\SomeOtherClass;

/**
 * Some class bla bla bla.
 */
class SomeClass {

  use StringTranslationTrait;

  /**
   * @return array
   *   Array of nodes.
   */
  protected function request() {
    return node_load([]);
  }

}
