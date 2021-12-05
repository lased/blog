<?

namespace App\Controllers;

use Framework\Base\Controller;

class ErrorController extends Controller
{
    public $layout = 'error';

    function setCodeView(int $code = 500)
    {
        $this->view = "{$code}";
    }
}
