<?

namespace App\Models;

use Framework\Base\Model;

class ArticleModel extends Model
{
  public $id;
  public $title;
  public $image;
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
      'image' => 'required',
      'title' => 'required|min:8',
      'content' => 'required|min:8',
    ];
  }
}
