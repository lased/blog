<?

namespace Framework;

/**
 * Класс патерна Registry
 */
class Registry
{
    use TSingleton;
    private $properties = [];

    /**
     * Получить значение по ключу $key
     * 
     * @param string $key Ключ свойства
     * 
     * @return mixed Значение свойства по ключу
     */
    function get(string $key)
    {
        return $this->properties[$key] ?? null;
    }

    /**
     * Установить ключу $key значение $value
     * 
     * @param string $key Ключ свойства
     * @param mixed $value Новое значение
     * 
     * @return mixed Установленное значение
     */
    function set(string $key, $value)
    {
        return $this->properties[$key] = $value;
    }

    /**
     * Удалить свойство с ключом $key
     * 
     * @param string $key Ключ свойства
     * 
     * @return boolean Результат операции
     */
    function remove(string $key)
    {
        unset($this->properties[$key]);

        return true;
    }
}
