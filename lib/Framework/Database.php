<?

namespace Framework;

/**
 * Класс для инициализации базы данных под управлением RedBeanPhp
 */
class Database
{
    private $config;
    use TSingleton;

    /**
     * Конструктор класса Database
     * 
     * @param array $args Ассоциативный массив с параметрами
     */
    function __construct(array $args)
    {
        $this->config = $args[0] ?? [];
        $this->initialize();
    }

    /**
     * Инициализация базы данных
     */
    private function initialize()
    {
        if (!$this->config) {
            throw new \Exception('Не объявлена конфигурация базы данных', 500);
        }

        class_alias('\RedBeanPHP\R', '\R');
        \R::setup(
            "{$this->config['type']}:host={$this->config['host']};dbname={$this->config['dbname']}",
            $this->config['user'],
            $this->config['password']
        );

        if (!\R::testConnection()) {
            throw new \Exception('Нет подключения к базе данных', 500);
        }

        \R::freeze();
    }
}
