#!/bin/bash
#
# Run au automated test for this example, called by ./test.sh.
#

docker run --rm \
  -v $(pwd)/example08/modules_i_want_to_test:/var/www/html/modules/custom \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
