<?

namespace App\Controllers;

use Framework\Base\Controller;
use App\Models\UserModel;
use DateTime;

class MainController extends Controller
{
    function indexAction()
    {
        $user = new UserModel();
        var_dump($user->findAll());
        return [];
    }
}
