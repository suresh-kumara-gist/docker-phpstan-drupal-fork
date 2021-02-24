Example using a trait.

./example06/modules_i_want_to_test/some_module/src/SomeClass.php uses the t() function which is defined in the \Drupal\Core\StringTranslation\StringTranslationTrait trait, so it should not trigger a "undefined function" error.
