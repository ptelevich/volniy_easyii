<?php

namespace app\controllers;

use app\components\VkHelper;
use yii\easyii\components\Controller;
use Yii;

class VkController extends Controller
{
    public function actionAudioMy()
    {
        $vkHelper = new VkHelper();
        $response = $vkHelper->getMyAudio();

        return $this->render('audioMy', [
            'response' => $response
        ]);
    }
    public function actionAudioWall()
    {
        $vkHelper = new VkHelper();
        $response = $vkHelper->getWallAudio();

        var_dump($response);

        return $this->render('audioMy', [
            'response' => $response
        ]);
    }

    public function actionDownloadAudio()
    {
        header("Content-disposition: attachment; filename=audio.mp3");
        header("Content-type: mime/type");
        echo readfile(Yii::$app->request->post('audioUrl'));
        exit;
    }
}
