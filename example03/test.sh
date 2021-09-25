#!/bin/bash
#
# Run au automated test for this example, called by ./test.sh.
#

docker run --rm \
  -v $(pwd)/example03/modules_i_want_to_test:/var/www/html/modules/custom \
  -v $(pwd)/example03/phpstan-drupal:/phpstan-drupal \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
