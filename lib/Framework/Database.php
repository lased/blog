<?

namespace Framework;

class Database
{
    use TSingleton;

    function __construct($args = [])
    {
        $config = $args[0] ?? [];

        if (!$config)
            throw new \Exception('Server error: Database config not specifed', 500);

        class_alias('\RedBeanPHP\R', '\R');
        \R::setup(
            "{$config['type']}:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );

        if (!\R::testConnection())
            throw new \Exception('Server error: No connection to database', 500);

        \R::freeze();
    }
}
