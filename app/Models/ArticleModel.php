<?

namespace App\Models;

use Framework\Base\Model;

class ArticleModel extends Model
{
  public $id;
  public $title;
  public $content;
  public $created_at;
  public $updated_at;

  static function table()
  {
    return 'articles';
  }

  static function rules()
  {
    return [
      'title' => 'required|min:8',
      'content' => 'required|min:8',
    ];
  }

  
}
