Very basic example.

./example01/modules_i_want_to_test/some_module/src/SomeClass.php contains a call to Drupal's \Drupal\Component\Utility\Unicode class; this will not cause an error because phpstan-drupal knows about all drupal code.
