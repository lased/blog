<?

namespace Framework;

class Registry
{
    use TSingleton;
    private $properties = [];

    function get($key)
    {
        return $this->properties[$key] ?? null;
    }

    function set($key, $value)
    {
        return $this->properties[$key] = $value;
    }

    function remove($key)
    {
        unset($this->properties[$key]);

        return true;
    }
}
