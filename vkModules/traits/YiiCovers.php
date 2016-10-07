<?php
namespace fedoskin\vkModules\traits;

use Yii;

trait YiiCovers
{
    public function renderView($view, $params)
    {
        return Yii::$app->controller->render('@fedoskinVkModulesViews/' . $view, $params);
    }
}