#!/bin/bash
#
# Run au automated test for this example, called by ./test.sh.
#

docker run --rm \
  -v $(pwd)/example04/some_module:/var/www/html/modules/custom/some_module \
  -v $(pwd)/example04/phpstan-drupal:/phpstan-drupal \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
