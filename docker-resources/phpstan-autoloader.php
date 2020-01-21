<?php

/**
 * @file
 * PHPstan class autoloader.
 *
 * PHPstan needs to know how to autoload classes to do its job.
 */

spl_autoload_register(function ($class) {
  // Always load dummy classes if they exist.
  // See example03 in github.com/dcycle/docker-phpstan-drupal.
  if (file_exists('/phpstan-drupal/dummy-classes.php')) {
    require_once '/phpstan-drupal/dummy-classes.php';
  }

  // Here $class will be something like
  // Drupal\some_module\SomeClass, in which case we need to include the class
  // modules/custom/some_module/src/SomeClass.php; or
  // Drupal\some_module\a\b\c\SomeClass, which should result in
  // modules/custom/some_module/src/a/b/c/SomeClass.php
  $matches = [];

  preg_match('/^Drupal\\\\([^\\\\]*)\\\\(.*)$/', $class, $matches);

  if (count($matches) == 3) {
    $module_name = $matches[1];
    $class_path = str_replace('\\', '/', $matches[2]);
    $candidate = 'modules/custom/' . $module_name . '/src/' . $class_path . '.php';
    if (file_exists($candidate)) {
      require_once $candidate;
    }
  }
});
