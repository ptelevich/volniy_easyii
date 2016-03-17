<?php
use yii\easyii\modules\article\api\Article;
use yii\easyii\modules\carousel\api\Carousel;
use yii\easyii\modules\gallery\api\Gallery;
use yii\easyii\modules\guestbook\api\Guestbook;
use yii\easyii\modules\news\api\News;
use app\modules\page\api\Page;
use yii\easyii\modules\text\api\Text;
use yii\helpers\Html;

$page = Page::get('page-index');

$this->title = $page->seo('title', $page->model->title);
?>

<style>
.row-cell {
    display: inline-table;
    width: 49%;
}
.row-cell div {
    padding-left: 0px;
}
</style>

<?= Carousel::widget(1140, 520) ?>

<div class="text-center">
    <h1><?= Text::get('index-welcome-title') ?></h1>
    <p><?= $page->text ?></p>
</div>

<br/>
<hr/>

<div class="text-center">
    <h2><?= Yii::t('appMain', 'main_photo_club') ?></h2>
    <br/>
    <?php foreach(Gallery::last(6) as $photo) : ?>
        <?= $photo->box(180, 135) ?>
    <?php endforeach;?>
    <?php Gallery::plugin() ?>
</div>

<br/>
<hr/>

<div class="text-center">
    <h2><?= Yii::t('appMain', 'main_news_club') ?></h2>
    <?php $newses = News::last(2) ?>
    <?php foreach ($newses as $news): ?>
        <blockquote class="row row-cell text-left">
            <?= Html::a($news->title, ['news/view', 'slug' => $news->slug]) ?>
            <br/>
            <?= $news->short ?>
        </blockquote>
    <?php endforeach; ?>
</div>

<br/>
<hr/>

<div class="text-center">
    <h2><?= Yii::t('appMain', 'menu_Articles') ?></h2>
    <br/>
    <?php $articles = Article::last(2, ['category_id' => 1]); ?>
    <?php foreach ($articles as $article): ?>
        <div class="row row-cell text-left">
            <div class="col-md-4">
                <?= Html::img($article->thumb(160, 120)) ?>
            </div>
            <div class="col-md-8 text-left" style="width: 50%;">
                <?= Html::a($article->title, ['articles/view', 'slug' => $article->slug]) ?>
                <br/>
                <?= $article->short ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<br/>
<hr/>

<div class="text-center">
    <h2><?= Yii::t('appMain', 'menu_Guestbook') ?></h2>
    <br/>
    <div class="row text-left" style="margin-left: 25px;">
        <?php foreach(Guestbook::last(2) as $post) : ?>
            <div class="col-md-5">
                <b><?= $post->name ?></b>
                <p class="text-muted"><?= $post->text ?></p>
            </div>
        <?php endforeach;?>
    </div>
</div>

<br/>
