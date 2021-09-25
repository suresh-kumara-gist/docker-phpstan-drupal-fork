#!/bin/bash
#
# Run au automated test for this example, called by ./test.sh.
#

echo "expecting this to fail because there is deprecated code node_load()"
! docker run --rm \
  -v $(pwd)/example07/modules_i_want_to_test:/var/www/html/modules/custom \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
echo "yay! failed."
