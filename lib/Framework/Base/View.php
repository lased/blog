<?

namespace Framework\Base;

use Framework\App;
use Framework\Helpers;

class View
{
    public $title = '';
    public $route;
    public $layout;
    public $view;

    function __construct($layout, $view)
    {
        $this->layout = $layout ?? (defined("LAYOUT") ? constant('LAYOUT') : 'DefaultLayout');
        $this->view = $view;
        $this->route = \Framework\Router::getRoute();
    }

    function render(array $data = [])
    {
        $path = App::$store->get('path');
        $path = $path ? $path . '/' : '';
        $layoutFile = "{$path}Layouts/{$this->layout}.php";
        $view = Helpers::camelCase($this->view ?? $this->route['action']);
        $prefix = !empty($this->route['prefix']) ? $this->route['prefix'] . '/' : '';
        $viewFile = "{$path}Views/{$prefix}{$this->route['controller']}/{$view}View.php";

        if ($data) extract($data);
        if (is_file($viewFile)) {
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        } else
            throw new \Exception("Представление {$viewFile} не найдено", 404);

        if ($this->layout === false)
            return $content;
        elseif (is_file($layoutFile))
            require_once $layoutFile;
        else
            throw new \Exception("Шаблон {$layoutFile} не найден", 404);
    }
}
