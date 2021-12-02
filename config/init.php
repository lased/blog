<?
define('PRODUCTION', true);
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CONFIG', ROOT . '/config');
define('LIB', ROOT . '/lib');
define('PUBLIC_HTML', ROOT . '/public_html');
define('UPLOADS', PUBLIC_HTML . '/uploads');

define('BASE_UPLOADS', '/uploads');

require_once ROOT . '/vendor/autoload.php';
