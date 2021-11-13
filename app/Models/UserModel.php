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
        return [];
    }
}
