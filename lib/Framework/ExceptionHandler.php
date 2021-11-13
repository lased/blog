<?

namespace Framework;

class ExceptionHandler
{
    private $path;

    function __construct(string $path)
    {
        if (!$path) throw new \Exception('Не корректный путь к файлу логов');

        $this->path = $path;

        if (defined('PRODUCTION'))
            error_reporting(0);

        error_reporting(-1);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    function exceptionHandler(\Throwable $exception)
    {
        $this->logToFile(
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage()
        );
        $this->showException($exception);
    }

    private function showException(\Throwable $exception)
    {
        var_dump($exception);
        die;
    }

    private function logToFile(string $file  = '', string $line = '', string $message = '')
    {
        $now = date('d-m-Y H:i:s');
        $content = "[{$now}] Исключение: {$message}\nФайл: {$file}\nСтрока: {$line}\n\n";

        $this->createDir();
        file_put_contents($this->path, $content, FILE_APPEND | LOCK_EX);
    }

    private function createDir()
    {
        $fileDirectory = implode('/', explode('/', $this->path, -1));

        if (!is_dir($fileDirectory)) {
            \mkdir($fileDirectory, 0777, true);
        }
    }
}
