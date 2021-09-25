set -e
docker build -t local-dcycle-phpstan-drupal-image .

for n in 1 2 3 4 5 6 7; do
  echo "---"
  echo "Testing example0$n"
  echo "---"
  ./example0"$n"/test.sh
  echo "---"
  echo "Done testing example0$n"
  echo "---"
done;
echo "---"
echo "Done testing all!"
echo "---"
