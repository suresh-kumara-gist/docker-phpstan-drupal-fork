# PHPStan-Drupal requires there to be a Drupal root.
# The dcycle/drupal images are updated Wednesdays after the security update
# window, and already have Composer installed. See
# https://github.com/dcycle/docker-drupal
FROM dcycle/drupal:9

COPY docker-resources/composer.json /var/www/html/composer.json
RUN composer update
COPY docker-resources/phpstan.neon /var/www/html/phpstan.neon
COPY docker-resources/phpstan-autoloader.php /var/www/html/phpstan-autoloader.php

ENTRYPOINT [ "/var/www/html/vendor/bin/phpstan", "analyse", "-c", "/var/www/html/phpstan.neon" ]
