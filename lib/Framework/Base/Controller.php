<?

namespace Framework\Base;

/**
 * Базовый класс Controller
 */
abstract class Controller
{
    public $route;
    public $layout;
    public $view;

    /**
     * Конструктор класса Controller
     */
    function __construct()
    {
        $this->route = \Framework\Router::getRoute();
    }

    /**
     * Получаем сгенерированное представление
     * 
     * @param array $data Пользовательский набор данных
     */
    function getView(array $data = [])
    {
        $viewObject = new View($this->layout, $this->view, $this->route);
        $viewObject->render($data);
    }
}
