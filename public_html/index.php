<?

use App\Controllers\ErrorController;

require_once dirname(__DIR__) . '/config/init.php';
require_once CONFIG . '/httpHeaders.php';
require_once CONFIG . '/routes.php';

$translate = require_once CONFIG . '/translate.php';

try {
    $app = new Framework\App([
        'log' => ROOT . '/temp/exceptions.log',
        'db' => require_once CONFIG . '/db.php',
        'path' => APP,
        'translate' => $translate
    ]);
} catch (\Throwable $th) {
    $controllerObject = new ErrorController();
    $controllerObject->route['controller'] = 'Error';
    $code = 500;

    if ($th->getCode() == 404) {
        $code = 404;
    }

    $controllerObject->setCodeView($code);
    $controllerObject->getView();
}
