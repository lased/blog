<?

namespace Framework;

trait TSingleton
{
    private static $instance;

    static function getInstance(...$args)
    {
        if (!self::$instance) {
            $instance = new self($args);
        }

        return $instance;
    }
}
