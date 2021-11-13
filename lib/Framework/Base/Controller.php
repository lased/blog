<?

namespace Framework\Base;

abstract class Controller
{
    public $route = [];
    public $layout;
    public $view;

    function __construct()
    {
        $this->route = \Framework\Router::getRoute();
    }

    function getView(array $data = [])
    {
        $viewObject = new View($this->layout, $this->view);
        $viewObject->render($data);
    }
}
