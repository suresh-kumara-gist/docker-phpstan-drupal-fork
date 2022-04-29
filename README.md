[![CircleCI](https://circleci.com/gh/dcycle/docker-phpstan-drupal.svg?style=svg)](https://circleci.com/gh/dcycle/docker-phpstan-drupal)

Perform static analysis of Drupal PHP code with [PHPStan](https://github.com/phpstan/phpstan) and [PHPStan-Drupal](https://github.com/mglaman/phpstan-drupal) on Drupal using PHP 8.

For example:

    docker run --rm \
      -v $(pwd)/example01/modules_i_want_to_test:/var/www/html/modules/custom \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom
    docker run --rm \
      -v $(pwd)/example02/modules_i_want_to_test:/var/www/html/modules/custom \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom
    docker run --rm \
      -v $(pwd)/example03/modules_i_want_to_test:/var/www/html/modules/custom \
      -v $(pwd)/example03/phpstan-drupal:/phpstan-drupal \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom
    docker run --rm \
      -v $(pwd)/example04/some_module:/var/www/html/modules/custom/some_module \
      -v $(pwd)/example04/phpstan-drupal:/phpstan-drupal \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom

Ignoring a single line of code
-----

PHPStan by itself supports ignoring an error on a single line, like this:

    // @phpstan-ignore-next-line
    ...some offending code...;

or even:

    // Whatever whatever @phpstan-ignore-next-line whatever whatever.
    ...some offending code...;

Obviously, we generally want to fix the underlying problem, but if for whatever reason you need to ignore an error, you can now do so.

Version history and migrating from one version to another
-----

* dcycle/phpstan-drupal:4 is based on Drupal 9, and PHP 8; Drupal 8-specific code will trigger errors; the deprecated `autoload_files` has been replaced with `bootstrapFiles` in `docker-resources/phpstan.neon`. Version 4 now also includes functionalty from [dcycle/docker-drupal-check](https://github.com/dcycle/docker-drupal-check).
* dcycle/phpstan-drupal:3 is based on Drupal 9; Drupal 8-specific code might trigger errors.
* dcycle/phpstan-drupal:2 uses `@phpstan-ignore-next-line` to ignore the next line of code.
* dcycle/phpstan-drupal:1 uses `phpstan:ignoreError` to ignore the next line of code.

Custom config file
-----

If you need a custom config file, for example if you want a different level, or to tell PHPStan to ignore certain files, you can do so by including the provided config file. See [example05](https://github.com/dcycle/docker-phpstan-drupal/tree/master/example05) for details; it can be run using:

    docker run --rm \
      -v $(pwd)/example05/modules_i_want_to_test:/var/www/html/modules/custom \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom \
      -c /var/www/html/modules/custom/phpstan.neon

If you look at the [custom config file in example05](https://github.com/dcycle/docker-phpstan-drupal/blob/master/example05/modules_i_want_to_test/phpstan.neon), it looks like this:

    # See https://github.com/dcycle/docker-phpstan-drupal/blob/master/README.md#custom-config-file
    parameters:
      excludePaths:
        - */tests/*
    includes:
      - /var/www/html/phpstan.neon

This tells PHPStan that we want our custom configuration exclude paths like `*/tests/*` from PHPStan analysis, and use the default `/var/www/html/phpstan.neon` for everything else. `/var/www/html/phpstan.neon` is not in your own code, it is in the dcycle/phpstan-drupal container. Its contents can be found [here](https://github.com/dcycle/docker-phpstan-drupal/blob/master/docker-resources/phpstan.neon).

Deprecation testing
-----

In the ./docker-resources/composer.json file you will find the following requirement [as per the PHPStan-Drpual documentation](https://github.com/mglaman/phpstan-drupal#deprecation-testing):

    phpstan/phpstan-deprecation-rules

In the ./docker-resources/phpstan.neon file you will find the following include, again as per the documentaiton:

    vendor/phpstan/phpstan-deprecation-rules/rules.neon

This means that when you have deprecated code in your codebase, it will be detected.

Troubleshooting
-----

Out of memory errors can be fixed by adding `--memory-limit=-1` to the end of your call, for example:

    docker run --rm \
      -v $(pwd)/example01/modules_i_want_to_test:/var/www/html/modules/custom \
      dcycle/phpstan-drupal:4 /var/www/html/modules/custom \
      --memory-limit=-1

Speed increase if using the M1 chip
-----

* See [Docker PHP on the M1 chip, example with Static Analysis on Drupal: 9 times faster, Dcycle Blog, November 17, 2021](https://blog.dcycle.com/blog/2021-11-17/m1-docker-php-speed-test/).

Resources
-----

* [This project on GitHub](https://github.com/dcycle/docker-phpstan-drupal)
* [This project on Docker Hub](https://hub.docker.com/r/dcycle/phpstan-drupal)
