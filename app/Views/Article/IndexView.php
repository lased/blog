<?
$this->params = [
    'styles' => [
        ['href' => '/static/article/index.css']
    ]
]
?>
<div class="wrapper">
    <h1 class="content__title">
        <?= $article['title'] ?>
    </h1>
    <div class="content__date">
        <?= $article['created_at'] ?>
    </div>
    <img class="content__image" src="<?= $article['image'] ?>">
    <div class="content__text"> <?= $article['content'] ?></div>
</div>