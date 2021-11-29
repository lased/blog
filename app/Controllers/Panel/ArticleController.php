<?

namespace App\Controllers\Panel;

use App\Models\ArticleModel;
use Framework\Router;

class ArticleController extends PanelController
{
  public $articleListUrl = '/panel/article/list';

  function listAction()
  {
    $page = 1;
    $rowlimits = [
      '5' => false,
      '10' => false,
      '15' => false
    ];
    $sortValues = [
      [
        'value' => 'date|ASC',
        'text' => 'Дата публикации по возрастанию'
      ],
      [
        'value' => 'date|DESC',
        'text' => 'Дата публикации по убыванию'
      ],
    ];

    if (isset($_GET['limit'])) {
      $rowlimits[$_GET['limit']] = true;
    } else {
      $rowlimits['5'] = true;
    }

    if (isset($_GET['sort'])) {
      $sortValues = array_map(function ($sort) {
        if ($sort['value'] === $_GET['sort']) {
          $sort['checked'] = true;
        }

        return $sort;
      }, $sortValues);
    } else {
      $sortValues[0]['checked'] = true;
    }

    if (isset($_GET['page'])) {
      $page = intval($_GET['page']) || 1;
    }

    return [
      'articles' => ArticleModel::findAll(),
      'rowsCount' => ArticleModel::count(),
      'rowlimits' => $rowlimits,
      'sortValues' => $sortValues,
      'page' => $page,
      'search' => $_GET['search'] ?? ''
    ];
  }

  function createAction()
  {
    $this->view = 'index';

    if ($_POST) {
      $article = new ArticleModel($_POST);

      if ($article->validate() && $article->save()) {
        Router::redirect($this->articleListUrl);

        return null;
      }

      return $article->getErrors();
    }

    return null;
  }

  function updateAction()
  {
    $this->view = 'index';
    $this->generateExceptionByRouteId();

    if ($_POST) {
      $updatedArticle = new ArticleModel($_POST);
      $result = $updatedArticle->update($this->route['id']);

      if ($result) {
        Router::redirect($this->articleListUrl);

        return null;
      }
    }

    $article = ArticleModel::findById($this->route['id']);

    if (!$article) {
      throw new \Exception("Статья не найдена", 404);
    }

    return $article;
  }

  function deleteAction()
  {
    $this->generateExceptionByRouteId();

    if (ArticleModel::delete($this->route['id'])) {
      Router::redirect($this->articleListUrl);

      return null;
    }
  }

  private function generateExceptionByRouteId()
  {
    if (!isset($this->route['id'])) {
      throw new \Exception("Страница не найдена", 404);
    }
  }
}
