<?php
namespace app\modules\page;

use Yii;

class PageModule extends \yii\easyii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Pages',
            'ru' => 'Страницы',
        ],
        'icon' => 'file',
        'order_num' => 50,
    ];
}