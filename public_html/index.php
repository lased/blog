<?

use Framework\Router;

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
    if ($th->getCode() === 404) {
        Router::redirect('/error/404');
        exit;
    }

    Router::redirect('/error/500');
    exit;
}
