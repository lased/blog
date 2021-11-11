<?

namespace Framework;

class Router
{
    private static $route = [];
    private static $routes = [];

    static function getRoute()
    {
        return self::$route;
    }

    static function add(string $pattern, array $route = [])
    {
        self::$routes[$pattern] = $route;

        return true;
    }

    static function dispatch(string $uri)
    {
        $uri = self::removeQueryString($uri);
        self::add('^(?P<controller>[a-zA-Z0-9-]+)?/?(?P<action>[a-zA-Z0-9-]+)?$');

        if (self::matchRoute($uri)) {
            $prefix = !empty(self::$route['prefix']) ? self::$route['prefix'] . '\\' : '';
            $camelCaseController = self::$route['controller'];
            $controller = "\App\Controllers\\" . $prefix . "{$camelCaseController}Controller";
            $action = lcfirst(self::$route['action']) . 'Action';

            if (class_exists($controller)) {
                $controllerObject = new $controller();

                if (method_exists($controllerObject, $action)) {
                    $data = $controllerObject->$action();
                    $controllerObject->getView($data);
                } else
                    throw new \Exception("Метод {$action} не найден", 404);
            } else
                throw new \Exception("Контроллер {$controller} не найден", 404);
        } else
            throw new \Exception("Страница не найдена", 404);
    }

    private static function matchRoute(string $uri)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $uri, $matches)) {
                foreach ($matches as $key => $value)
                    if (is_string($key))
                        $route[$key] = $value;

                $route['controller'] = Helpers::camelCase($route['controller'] ?? 'Main');
                $route['action'] = Helpers::camelCase($route['action'] ?? 'Index');
                self::$route =  $route;

                return true;
            }

            return false;
        }
    }

    private static function removeQueryString(string $uri)
    {
        return trim(explode('?', $uri)[0], '/');
    }
}