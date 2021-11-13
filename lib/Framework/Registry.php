<?

namespace Framework;

class Registry
{
    use TSingleton;
    private $properties = [];

    function get(string $key)
    {
        return $this->properties[$key] ?? null;
    }

    function set(string $key, $value)
    {
        return $this->properties[$key] = $value;
    }

    function remove(string $key)
    {
        unset($this->properties[$key]);

        return true;
    }
}
