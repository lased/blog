<?

namespace Framework;

/**
 * Класс для работы с GET строкой
 */
class QueryString
{
    private $uri;

    /**
     * Конструктор класса QueryString
     * 
     * @param string $uri Строка GET запроса
     */
    function __construct(string $uri)
    {
        $this->uri = $this->parse($uri ?? '');
    }

    /**
     * Получить значение параметра по имени
     * 
     * @param string $name Имя параметра
     * 
     * @return string|null Значение параметра
     */
    function get(string $name)
    {
        return $this->uri[$name] ?? null;
    }

    /**
     * Задать значение параметру по имени
     * 
     * @param string $name Имя параметра
     * @param string $value Значение параметра
     * 
     * @return string Значение параметра
     */
    function set(string $name, string $value)
    {
        $this->uri[$name] = $value ?? '';

        return $this->uri[$name];
    }

    /**
     * Удалить параметр из GET запроса
     * 
     * @param string $name Имя параметра
     * 
     * @return string Удаленное имя параметра
     */
    function remove(string $name)
    {
        unset($this->uri[$name]);

        return $name;
    }

    /**
     * Преобразование в строку GET запроса
     * 
     * @return string Строка GET запроса
     */
    function toString()
    {
        return implode('&', array_map(function ($value, $key) {
            return "$key=$value";
        }, $this->uri, array_keys($this->uri)));
    }

    /**
     * Парсинг uri строки в ассоциативный массив
     * 
     * @param string $uri Строка GET запроса
     * 
     * @return array Ассоциативный массив (параметр - значение)
     */
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
