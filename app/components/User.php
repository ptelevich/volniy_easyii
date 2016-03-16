<?php

namespace app\components;

use app\models\Admin;

class User extends \yii\web\User
{
    protected function renewAuthStatus()
    {
        $this->identityClass = $this->identityClass[0];
        return parent::renewAuthStatus();
    }
}
