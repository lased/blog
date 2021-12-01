<?

namespace App\Controllers;

use App\Models\ArticleModel;
use Framework\Base\Controller;

class MainController extends Controller
{
    function indexAction()
    {
        $page = 1;
        $limit = 5;

        if (!empty($_GET['page'])) {
            $page = intval($_GET['page']) ?: 1;
        }

        $search = !empty($_GET['search']) ? $_GET['search'] : '';
        $where = !empty($search) ? [
            'sql' => 'title LIKE :search',
            'params' => [':search' => "%$search%"]
        ] : [];

        return [
            'articles' => ArticleModel::findAll(
                [
                    // 'where' => $where,
                    'offset' => ($page - 1) * $limit,
                    'limit' => $limit,
                    'order' => [
                        'column' => 'created_at',
                        'dir' => 'desc'
                    ]
                ]
            ),
            'page' => $page,
            'limit' => $limit,
            'search' => $search,
            'rowsCount' => ArticleModel::count($where)
        ];
    }
}
