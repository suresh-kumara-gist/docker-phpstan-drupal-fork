# PHPStan-Drupal requires there to be a Drupal root.
# The dcycle/drupal images are updated Wednesdays after the security update
# window, and already have Composer installed. See
# https://github.com/dcycle/docker-drupal
FROM dcycle/drupal:8drush

RUN export COMPOSER_MEMORY_LIMIT=-1 && composer require \
  mglaman/phpstan-drupal

RUN pwd
RUN ls -lah vendor/phpstan/phpstan
RUN vendor/phpstan/phpstan/phpstan
RUN find . -name extension.neon

COPY docker-resources/composer.json /var/www/html/composer.json
RUN composer update
COPY docker-resources/phpstan.neon /var/www/html/phpstan.neon
COPY docker-resources/phpstan-autoloader.php /var/www/html/phpstan-autoloader.php
COPY docker-resources/IgnoredErrorsFilter.php /var/www/html/statictools/PHPStan/IgnoredErrorsFilter.php

ENTRYPOINT [ "/var/www/html/vendor/bin/phpstan", "analyse", "--error-format", "filtered", "-c", "/var/www/html/phpstan.neon" ]
