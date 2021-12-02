<?

namespace App\Controllers;

use Framework\Base\Controller;

class ErrorController extends Controller
{
    public $layout = 'error';

    function indexAction()
    {
        $this->view = '500';

        if ($this->route['id'] == 404) {
            $this->view = '404';
        }
    }
}
