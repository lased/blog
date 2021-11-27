<?

namespace App\Controllers\Panel;
use Framework\Router;

class MainController extends PanelController
{

    function indexAction()
    {
        Router::redirect('/panel/article/list');
    }
}
