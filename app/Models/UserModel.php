<?

namespace App\Models;

use DateTime;
use Framework\Base\Model;

class UserModel extends Model
{
    public $id;
    public $nickname;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    static function table()
    {
        return 'users';
    }

    static function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ];
    }

    function login()
    {
        $user = $this->findOne('email = ?', [$this->email]);

        if ($user && password_verify($this->password, $user['password'])) {
            $_SESSION['user'] = $user;

            return true;
        }

        return false;
    }
}
