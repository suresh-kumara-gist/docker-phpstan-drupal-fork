namespace Drupal\some_module;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\some_module\Whatever\SomeOtherClass;

/**
 * Some class bla bla bla.
 */
class SomeClass {

  /**
   * The cache service.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * Constructor to inject dependencies.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache service.
   */
  public function __construct(CacheBackendInterface $cache) {
    $this->cache = $cache;
  }

  /**
   * Request method.
   *
   * @param string $something
   *   A path.
   *
   * @return object|bool
   *   The JSON as a PHP object, or FALSE if an error occurred.
   */
  protected function request(string $something) {
    // Using dependency-injected cache service.
    $other_class = new SomeOtherClass();
    $other_class->sayHello();

    return $this->cache->get(mb_strtolower($something));
  }

}
