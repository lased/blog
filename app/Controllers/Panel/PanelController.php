<?

namespace App\Controllers\Panel;

use Framework\Base\Controller;
use Framework\Router;

class PanelController extends Controller
{
    public $layout = 'panel';

    public function __construct()
    {
        parent::__construct();

        if (empty($_SESSION['user'])) {
            Router::redirect('/panel/login');
        }
    }
}
