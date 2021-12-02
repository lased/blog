<?

namespace Framework;

class QueryString
{
    private $uri;

    function __construct(string $uri = '')
    {
        $this->uri = $this->parse($uri);
    }

    function get(string $name)
    {
        return $this->uri[$name] ?? null;
    }

    function set(string $name, string $value)
    {
        $this->uri[$name] = $value ?? '';

        return $this->uri[$name];
    }

    function remove(string $name)
    {
        unset($this->uri[$name]);

        return $name;
    }

    function toString()
    {
        return implode('&', array_map(function ($value, $key) {
            return "$key=$value";
        }, $this->uri, array_keys($this->uri)));
    }

    private function parse(string $uri)
    {
        $params = array_filter(explode('&', $uri), function ($value) {
            return $value;
        });
        $result = [];

        foreach ($params as $param) {
            $value = explode('=', $param);

            if (!$value[0]) {
                continue;
            }

            $result[$value[0]] = $value[1] ?? '';
        }

        return $result;
    }
}
