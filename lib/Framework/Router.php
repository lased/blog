<?

namespace Framework;

/**
 * Класс маршрутизации
 */
class Router
{
    private static $route = [];
    private static $routes = [];

    /**
     * Полуить текущий маршрут [
     *  'controller' => 'Controller',
     *  'action' => 'Action',
     *  'prefix' => 'admin',
     *  'id' => '1'
     * ]
     * 
     * @return array Текущий маршрут
     */
    static function getRoute()
    {
        return self::$route;
    }

    /**
     * Добавить маршрут по шаблону
     * 
     * @param string $pattern Шаблон маршрута RegExp
     * @param array $route Дополнительные параметры к маршруту 'prefix' => 'admin'
     * 
     * @return bool Результат операции
     */
    static function add(string $pattern, array $route = [])
    {
        self::$routes[$pattern] = $route;

        return true;
    }

    /**
     * Процесс поиска маршрута по определенному шаблону. После найденного маршрута, инициализируется контроллер, метод action и генерируется представление
     * 
     * @param string $uri URI адрес
     */
    static function dispatch(string $uri)
    {
        $uriArr = explode('?', $uri);
        $queryString = $uriArr[1] ?? '';
        $uri = trim($uriArr[0], '/');
        self::add('^(?P<controller>[a-zA-Z-]+)?\/?(?P<action>[a-zA-Z-]+)?\/?(?P<id>[0-9]+)?$');

        if (self::matchRoute($uri)) {
            $prefix = !empty(self::$route['prefix']) ? self::$route['prefix'] . '\\' : '';
            $camelCaseController = self::$route['controller'];
            $controller = "\App\Controllers\\" . $prefix . "{$camelCaseController}Controller";
            $action = lcfirst(self::$route['action']) . 'Action';
            self::$route['queryString'] = new QueryString($queryString);

            if (class_exists($controller)) {
                $controllerObject = new $controller();

                if (method_exists($controllerObject, $action)) {
                    $data = $controllerObject->$action();
                    $controllerObject->getView($data ?? []);
                } else {
                    throw new \Exception("Метод {$action} не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /**
     * Перенаправление по указаному адресу
     * 
     * @param string $uri Адрес перенаправления
     */
    static function redirect(string $uri)
    {
        header("Location: $uri");
        exit;
    }

    /**
     * Поиск валидного маршрута по указанному URI
     * 
     * @param string $uri URI адрес
     * 
     * @return bool Результат операции
     */
    private static function matchRoute(string $uri)
    {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $uri, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }

                $route['controller'] = Helpers::camelCase(!empty($route['controller']) ? $route['controller'] : 'Main');
                $route['action'] = Helpers::camelCase(!empty($route['action']) ? $route['action'] : 'Index');
                self::$route =  $route;

                return true;
            }
        }

        return false;
    }
}
