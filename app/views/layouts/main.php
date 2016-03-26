<?php
use yii\easyii\modules\shopcart\api\Shopcart;
use yii\easyii\modules\subscribe\api\Subscribe;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

$goodsCount = count(Shopcart::goods());
?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
<div id="wrapper" class="container">
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= Url::home() ?>"><?= Yii::t('appMain', 'company_name'); ?></a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-menu">
                    <?= Menu::widget([
                        'options' => ['class' => 'nav navbar-nav'],
                        'items' => [
                            ['label' => Yii::t('appMain', 'menu_Home'), 'url' => ['site/index']],
                            ['label' => Yii::t('appMain', 'menu_Shop'), 'url' => ['shop/index'], 'visible' => false],
                            ['label' => Yii::t('appMain', 'menu_News'), 'url' => ['news/index']],
                            ['label' => Yii::t('appMain', 'menu_Articles'), 'url' => ['articles/index']],
                            ['label' => Yii::t('appMain', 'menu_Gallery'), 'url' => ['gallery/index']],
                            ['label' => Yii::t('appMain', 'menu_Guestbook'), 'url' => ['guestbook/index']],
                            ['label' => Yii::t('appMain', 'menu_FAQ'), 'url' => ['faq/index']],
                            ['label' => Yii::t('appMain', 'menu_Contact'), 'url' => ['/contact/index']],
                        ],
                    ]); ?>
                    <a href="<?= Url::to(['/shopcart']) ?>" class="btn btn-default navbar-btn navbar-right" title="Complete order">
                        <i class="glyphicon glyphicon-shopping-cart"></i>
                        <?php if($goodsCount > 0) : ?>
                            <?= $goodsCount ?> <?= $goodsCount > 1 ? 'items' : 'item' ?> - <?= Shopcart::cost() ?>$
                        <?php else : ?>
                            <span class="text-muted"><?= Yii::t('appMain', 'basket_empty') ?></span>
                        <?php endif; ?>
                    </a>

                </div>
            </div>
        </nav>
    </header>
    <main>
        <?php if($this->context->id != 'site') : ?>
            <br/>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])?>
        <?php endif; ?>
        <?= $content ?>
        <div class="push"></div>
    </main>
</div>
<footer>
    <div class="container footer-content">
        <div class="row">
            <div class="col-md-3">
                Подписаться на рассылку
            </div>
            <div class="col-md-5">
                <?php if(Yii::$app->request->get(Subscribe::SENT_VAR)) : ?>
                    Вы успешно подписаны
                <?php else : ?>
                    <?= Subscribe::form() ?>
                <?php endif; ?>
            </div>
            <div class="col-md-4 text-right">
                ©<?= date('Y') . ' ' . Yii::t('appMain', 'company_name'); ?>
            </div>
        </div>
    </div>
</footer>
<?php $this->endContent(); ?>
