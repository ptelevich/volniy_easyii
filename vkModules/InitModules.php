<?php
namespace fedoskin\vkModules;

use yii\web\HttpException;
use Yii;

class InitModules
{
    public $modules;
    public $config;

    private $modulesNamespace = 'fedoskin\\vkModules\\modules\\';

    public function getModule($moduleName)
    {
        Yii::setAlias('@fedoskinVkModules', __DIR__);
        Yii::setAlias('@fedoskinVkModulesViews', __DIR__ . '/views');

        if (in_array($moduleName, $this->modules)) {
            $className = $this->modulesNamespace.$moduleName;
            if (class_exists($className)) {
                $module = new $className;
                foreach ($this->config as $configName => $configValue) {
                    $module->{$configName} = $configValue;
                }

                if (method_exists($module, 'run')) {
                    return $module->run(Yii::$app->request->get('action', null));
                } else {
                    throw new HttpException(501, 'Please add "run()" method in class ' . $moduleName);
                }
            }
        }

        throw new HttpException(503, 'Module name "'.$moduleName.'" is incorrect');
    }
}