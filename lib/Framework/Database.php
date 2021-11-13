<?

namespace Framework;

class Database
{
    use TSingleton;

    function __construct(array $args = [])
    {
        $config = $args[0] ?? [];

        if (!$config)
            throw new \Exception('Не объявлена конфигурация базы данных', 500);

        class_alias('\RedBeanPHP\R', '\R');
        \R::setup(
            "{$config['type']}:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );

        if (!\R::testConnection())
            throw new \Exception('Нет подключения к базе данных', 500);

        \R::freeze();
    }
}
