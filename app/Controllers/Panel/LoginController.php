<?

namespace App\Controllers\Panel;

use App\Models\UserModel;
use Framework\Base\Controller;
use Framework\Router;

class LoginController extends Controller
{
    public $layout = false;

    function indexAction()
    {
        if (!$_POST) return;

        $user = new UserModel($_POST);
        $result = ['email' => $user->email];

        if ($user->validate())
            if ($user->login())
                Router::redirect('/panel');
            else
                return $result + ['errors' => ['Не верный логин или пароль']];
        else
            return $result + ['errors' => $user->getErrors()];
    }
}
