<?

namespace Framework;

/**
 * Класс обработчика ошибок
 */
class ExceptionHandler
{
    private $path;

    /**
     * Конструктор класса ExceptionHandler
     * 
     * @param string $path Путь к файлу логирования
     */
    function __construct(string $path)
    {
        if (!$path) {
            throw new \Exception('Не корректный путь к файлу логирования');
        }

        $this->path = $path;

        if (defined('PRODUCTION') && constant('PRODUCTION')) {
            error_reporting(0);
        }

        error_reporting(-1);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * Обработчик ошибок
     * 
     * @param \Throwable $exception Исключение
     */
    function exceptionHandler(\Throwable $exception)
    {
        $this->logToFile(
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage()
        );

        if (!defined('PRODUCTION') || !constant('PRODUCTION')) {
            $this->showException($exception);
        }
    }

    /**
     * Вывод содержимого исключения
     * 
     * @param \Throwable $exception Исключение
     */
    private function showException(\Throwable $exception)
    {
        var_dump($exception);
        exit;
    }

    /**
     * Запись данных исключения в файл
     * 
     * @param string $file Файл, в котором возникло исключение
     * @param string $line Строка, в которой возникло исключение
     * @param string $message Сообщение исключения
     */
    private function logToFile(string $file  = '', string $line = '', string $message = '')
    {
        $now = date('d-m-Y H:i:s');
        $content = "[{$now}] Исключение: {$message}\nФайл: {$file}\nСтрока: {$line}\n\n";

        $this->createDir();
        file_put_contents($this->path, $content, FILE_APPEND | LOCK_EX);
    }

    /**
     * Создание директории для логирования
     */
    private function createDir()
    {
        $fileDirectory = implode('/', explode('/', $this->path, -1));

        if (!is_dir($fileDirectory)) {
            \mkdir($fileDirectory, 0777, true);
        }
    }
}
