<?php
use yii\easyii\modules\article\api\Article;
use yii\easyii\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-articles');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

/*
 * Default code
 *
 * function renderNode($node){
    if(!count($node->children)){
        $html = '<li>'.Html::a($node->title, ['/articles/cat', 'slug' => $node->slug]).'</li>';
    } else {
        $html = '<li>'.$node->title.'</li>';
        $html .= '<ul>';
        foreach($node->children as $child) $html .= renderNode($child);
        $html .= '</ul>';
    }
    return $html;
    <ul>
        <?php foreach(Article::tree() as $node) echo renderNode($node); ?>
    </ul>
}*/
?>
<h1 align="center"><?= $page->seo('h1', $page->title) ?></h1>

<br/>

<?php if(count($items)) : ?>
    <?php foreach($items as $article) : ?>
        <div class="row">
            <div class="col-md-2">
                <?= Html::img($article->thumb(160, 120)) ?>
            </div>
            <div class="col-md-10">
                <?= Html::a($article->title, ['articles/view', 'slug' => $article->slug]) ?>
                <p><?= $article->short ?></p>
                <p>
                    <?php foreach($article->tags as $tag) : ?>
                        <a href="<?= Url::to(['/articles/cat', 'slug' => $article->cat->slug, 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
<?php else : ?>
    <p>Category is empty</p>
<?php endif; ?>