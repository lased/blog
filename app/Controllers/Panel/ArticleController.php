<?

namespace App\Controllers\Panel;

use App\Models\ArticleModel;
use Framework\Router;

class ArticleController extends PanelController
{
  public $articleListUrl = '/panel/article/list';

  function listAction()
  {
    $order = [];
    $page = 1;
    $rowlimits = [
      '5' => false,
      '10' => false,
      '15' => false
    ];
    $sortValues = [
      [
        'value' => 'created_at|ASC',
        'text' => 'Дата публикации по возрастанию'
      ],
      [
        'value' => 'created_at|DESC',
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
      $sortValues[1]['checked'] = true;
    }

    if (isset($_GET['page'])) {
      $page = intval($_GET['page']) ?: 1;
    }

    foreach ($sortValues as $value) {
      if ($value['checked'] ?? false) {
        $split = preg_split('/\|/', $value['value']);
        $order = ['column' => $split[0], 'dir' => $split[1]];
      }
    }

    $limit = array_search(true, $rowlimits);

    return [
      'articles' => ArticleModel::findAll(
        [
          'offset' => ($page - 1) * $limit,
          'limit' => $limit,
          'order' => $order
        ]
      ),
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

      if (!empty($_FILES) && $_FILES['image']['name']) {
        $article->image = $_FILES['image']['name'];
      }

      if ($article->validate()) {
        $article->image = BASE_UPLOADS . $this->uploadImage($_FILES['image']);

        if (!$article->save()) {
          throw new \Exception('Произошла ошибка при сохранении записи', 500);
        }

        Router::redirect($this->articleListUrl);

        return null;
      }

      return [
        'errors' => $article->getErrors(),
        'article' => $article
      ];
    }

    return null;
  }

  function updateAction()
  {
    $this->view = 'index';
    $this->generateExceptionByRouteId();
    $article = ArticleModel::findById($this->route['id']);

    if ($_POST) {
      $updatedArticle = new ArticleModel($_POST);

      if (!empty($_FILES) && $_FILES['image']['name']) {
        if (!unlink(PUBLIC_HTML . $article['image']) || !rmdir(dirname(PUBLIC_HTML . $article['image']))) {
          throw new \Exception('Произошла ошибка при сохранении записи', 500);
        }

        $updatedArticle->image = BASE_UPLOADS . $this->uploadImage($_FILES['image']);
      }

      $result = $updatedArticle->update($this->route['id']);

      if ($result) {
        Router::redirect($this->articleListUrl);

        return null;
      }
    }

    if (!$article) {
      throw new \Exception("Статья не найдена", 404);
    }

    return [
      'article' => $article
    ];
  }

  function deleteAction()
  {
    $this->generateExceptionByRouteId();

    if (ArticleModel::delete($this->route['id'])) {
      Router::redirect($this->articleListUrl);

      return null;
    }
  }

  private function uploadImage($image)
  {
    $folder = \Ramsey\Uuid\Uuid::uuid4();
    $filename = \Ramsey\Uuid\Uuid::uuid4() . '.' . preg_split('/\//', $image['type'])[1];
    $path = "/$folder/$filename";

    if (
      !mkdir(UPLOADS . '/' . $folder)
      || !move_uploaded_file($image['tmp_name'], UPLOADS . $path)
    ) {
      throw new \Exception('Произошла ошибка при создании файла на сервере', 500);
    }

    return $path;
  }

  private function generateExceptionByRouteId()
  {
    if (!isset($this->route['id'])) {
      throw new \Exception("Страница не найдена", 404);
    }
  }
}
