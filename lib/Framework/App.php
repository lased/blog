<?

namespace Framework;

/**
 * Класс приложения
 */
class App
{
    public static $store;

    /**
     * Конструктор класса App
     * 
     * @param array $config Конфигурация приложения. 
     * Путь к файлу логирования - 'log', ***
     * параметры БД - 'db' => ['type', 'host', 'dbname', 'user', 'password'],
     * путь к приложению - 'path',
     * перевод текста валидатора - 'translate'
     */
    function __construct(array $config = [])
    {
        session_start();
        $this->initExceptionHandler($config['log'] ?? '');
        self::$store = Registry::getInstance();
        $this->loadConfig($config);
        Database::getInstance($config['db'] ?? []);
        Router::dispatch($_SERVER['REQUEST_URI']);
    }

    /** 
     * Загрузка конфигурации в приложение
     * 
     * @param array $config Конфигурация приложения
     */
    private function loadConfig(array $config = [])
    {
        if ($config) {
            foreach ($config as $key => $value) {
                self::$store->set((string) $key, $value);
            }
        }
    }

    /** 
     * Регистрация собственного обработчика ошибок
     * 
     * @param string $path Путь к файлу логирования 
     */
    private function initExceptionHandler(string $path)
    {
        if ($path) {
            new ExceptionHandler($path);
        }
    }
}
