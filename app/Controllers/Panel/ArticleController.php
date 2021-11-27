<?

namespace App\Controllers\Panel;

use App\Models\ArticleModel;
use Framework\Router;

class ArticleController extends PanelController
{
  public $articleListUrl = '/panel/article/list';

  function listAction()
  {
    $articles = ArticleModel::findAll();

    return ['articles' => $articles];
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
