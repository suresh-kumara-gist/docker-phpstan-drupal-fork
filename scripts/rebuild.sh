#!/bin/bash
# Rebuild script
# This is meant to be run on a regular basis to make sure everything works with
# the latest version of scripts.

set -e

# Always test before rebuilding as the API can have changed, for example at
# https://github.com/phpstan/phpstan-src/commit/3e1ce5d06e574c6da93b8fa3dcf8569f8f8fcff3#diff-c9426bbd63493f10ff3790c0f0d13f99R39
./test.sh

CREDENTIALS="$HOME/.dcycle-docker-credentials.sh"

if [ ! -f "$CREDENTIALS" ]; then
  echo "Please create $CREDENTIALS and add to it:"
  echo "DOCKERHUBUSER=xxx"
  echo "DOCKERHUBPASS=xxx"
  exit;
else
  source "$CREDENTIALS";
fi

./test.sh

PROJECT=phpstan-drupal
DATE=`date '+%Y-%m-%d-%H-%M-%S-%Z'`
MAJORVERSION='3'
VERSION='3.0'

# Start by getting the latest version of the official drupal image
docker pull dcycle/drupal:9
# Rebuild the entire thing
docker build --no-cache -t dcycle/"$PROJECT":"$VERSION" .
docker build -t dcycle/"$PROJECT":"$MAJORVERSION" .
docker build -t dcycle/"$PROJECT":"$MAJORVERSION".$DATE .
docker build -t dcycle/"$PROJECT":"$VERSION".$DATE .
docker login -u"$DOCKERHUBUSER" -p"$DOCKERHUBPASS"
docker push dcycle/"$PROJECT":"$VERSION"
docker push dcycle/"$PROJECT":"$MAJORVERSION"
docker push dcycle/"$PROJECT":"$VERSION"."$DATE"
docker push dcycle/"$PROJECT":"$MAJORVERSION"."$DATE"
# No longer using the latest tag, use the major version tag instead.
