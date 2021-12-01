<?

namespace App\Controllers;

use App\Models\ArticleModel;
use Framework\Base\Controller;

class ArticleController extends Controller
{
    function indexAction()
    {
        if (empty($this->route['id'])) {
            throw new \Exception('Страница не найдена', 404);
        }

        $article = ArticleModel::findById($this->route['id']) ?? [];

        if (empty($article)) {
            throw new \Exception('Статья не найдена', 404);
        }

        return [
            'article' => $article
        ];
    }
}
