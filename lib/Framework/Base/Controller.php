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

    function responseJSON($array, $headers = [])
    {
        foreach ($headers as $key => $value)
            header("{$key}: {$value}");

        $headers['Content-Type'] = 'application/json';
        echo json_encode($array);
        exit;
    }
}
