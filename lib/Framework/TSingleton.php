<?

namespace Framework;

/**
 * Trait паттерна Singleton
 */
trait TSingleton
{
    private static $instance;

    /**
     * Получить экземпляр обьекта
     * 
     * @return $this
     */
    static function getInstance(...$args)
    {
        if (!self::$instance) {
            $instance = new self($args);
        }

        return $instance;
    }
}
