<?

use Framework\Router;

Router::add(
    '^panel\/?(?P<controller>[a-z-]+)?\/?(?P<action>[a-z-]+)?\/?(?P<id>[0-9]+)?$',
    ['prefix' => 'panel']
);
