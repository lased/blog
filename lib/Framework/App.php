<?

namespace Framework;

class App
{
    public static $store;

    function __construct(array $config = [])
    {
        session_start();
        $this->initExceptionHandler($config['log'] ?? '');
        Database::getInstance($config['db'] ?? []);
        self::$store = Registry::getInstance();
        $this->loadConfig($config);
        Router::dispatch($_SERVER['REQUEST_URI']);
    }

    private function loadConfig(array $config = [])
    {
        if ($config)
            foreach ($config as $key => $value) {
                self::$store->set((string) $key, $value);
            }
    }

    private function initExceptionHandler(string $path)
    {
        if ($path)
            new ExceptionHandler($path);
    }
}
