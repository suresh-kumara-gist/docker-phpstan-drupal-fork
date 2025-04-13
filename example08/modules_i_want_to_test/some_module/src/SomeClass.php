<?php

namespace Drupal\some_module;

/**
 * Some class bla bla bla.
 * See https://phpstan.org/writing-php-code/phpdocs-basics#magic-methods
 * @method string sayHello(string $name)
 */
class SomeClass {

  public function __call ( string $name , array $arguments ) : mixed {
    if ($name == 'sayHello' && $arguments['name'] == 'world') {
      return 'Hello world';
    }
    return NULL;
  }

  public function callSayHello() : string {
    return $this->sayHello('world');
  }

}
