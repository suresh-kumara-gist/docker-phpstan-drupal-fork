<?php

namespace Drupal\some_module;

use Drupal\some_third_party_module\SomeThirdPartyModuleClass;
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
    // SomeThirdPartyModuleClass is NOT in our code. We get around this
    // by telling PHPStan what this class looks like in
    // phpstan-drupal-dummy-classes.php
    return SomeThirdPartyModuleClass::sayHello();
  }

}
