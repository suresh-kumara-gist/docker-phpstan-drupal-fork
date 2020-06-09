set -e
docker pull dcycle/drupal:8drush
docker build -t local-dcycle-phpstan-drupal-image .

docker run --rm \
  -v $(pwd)/example01/modules_i_want_to_test:/var/www/html/modules/custom \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
docker run --rm \
  -v $(pwd)/example02/modules_i_want_to_test:/var/www/html/modules/custom \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
docker run --rm \
  -v $(pwd)/example03/modules_i_want_to_test:/var/www/html/modules/custom \
  -v $(pwd)/example03/phpstan-drupal:/phpstan-drupal \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
docker run --rm \
  -v $(pwd)/example04/some_module:/var/www/html/modules/custom/some_module \
  -v $(pwd)/example04/phpstan-drupal:/phpstan-drupal \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom
docker run --rm \
  -v $(pwd)/example05/modules_i_want_to_test:/var/www/html/modules/custom \
  local-dcycle-phpstan-drupal-image /var/www/html/modules/custom \
  -c /var/www/html/modules/custom/phpstan.neon
