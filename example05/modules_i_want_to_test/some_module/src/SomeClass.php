<?php

namespace Drupal\some_module;

use Drupal\Component\Utility\Unicode;
use Drupal\some_module\Whatever\SomeOtherClass;

/**
 * Some class bla bla bla.
 */
class SomeClass {

  /**
   * @param string $something
   *   A path
   * @return object
   *   The JSON as a PHP object, or FALSE if an error occurred
   */
  protected function request(string $something) {
    $other_class = new SomeOtherClass();
    $other_class->sayHello();

    return json_decode(Unicode::truncate($something, 20));
  }

}
