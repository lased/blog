<?

use Framework\Router;

Router::add(
    '^panel\/?(?P<controller>[a-zA-Z-]+)?\/?(?P<action>[a-zA-Z-]+)?\/?(?P<id>[0-9]+)?$',
    ['prefix' => 'panel']
);
