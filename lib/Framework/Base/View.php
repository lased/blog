<?

namespace Framework\Base;

use Framework\App;
use Framework\Helpers;

/**
 * Базовый класс представления
 */
class View
{
    public $title = '';
    public $route;
    public $layout;
    public $view;

    /**
     * Конструктор класса View
     * 
     * @param bool|string $layout Наименование файла шаблона или false для отключения шаблонизации
     * @param string $view Наименование файла представления
     * @param array $route Набор данных по текущему маршруту
     */
    function __construct($layout, $view, $route)
    {
        $this->layout = $layout ?? (defined("LAYOUT") ? constant('LAYOUT') : 'default');
        $this->view = $view;
        $this->route = $route;
    }

    /**
     * Отрисовка представления. Пример: 
     * для layoutFile - $path/Layouts/DefaultLayout.php,
     * для viewFile - $path/Views/$prefix/MainController/IndexView.php
     * 
     * @param array $data Пользовательский набор данных
     */
    function render(array $data = [])
    {
        $path = App::$store->get('path');
        $path = $path ? $path . '/' : '';
        $layoutFile = "{$path}Layouts/" . ucfirst($this->layout) . "Layout.php";
        $view = Helpers::camelCase($this->view ?? $this->route['action']);
        $prefix = !empty($this->route['prefix']) ? $this->route['prefix'] . '/' : '';
        $viewFile = "{$path}Views/{$prefix}{$this->route['controller']}/{$view}View.php";

        if ($data) {
            extract($data);
        }
        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else {
            throw new \Exception("Представление {$viewFile} не найдено", 404);
        }

        if ($this->layout === false) {
            echo $content;
        } elseif (is_file($layoutFile)) {
            require_once $layoutFile;
        } else {
            throw new \Exception("Шаблон {$layoutFile} не найден", 404);
        }
    }
}
