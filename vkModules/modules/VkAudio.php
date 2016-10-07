<?php
namespace fedoskin\vkModules\modules;

use fedoskin\vkModules\traits\YiiCovers;
use Yii;
use yii\authclient\clients\VKontakte;
use yii\authclient\Collection as AuthClientCollection;
use fedoskin\vkModules\helpers\Auth;
use fedoskin\vkModules\traits\Logs;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;

/**
 * @property VKontakte $vkObject
 */
class VkAudio extends Auth
{
    use Logs;
    use YiiCovers;

    /**
     * @example http://volniy.loc/vk/audio?action=myOwn
    */
    public function run($action)
    {
        if ($this->makeOAuth()) {
            $this->_setLog(['mess' => 'success make OAuth']);
        }
        if ($action && method_exists($this, $action)) {
            return $this->$action();
        }

        throw new NotFoundHttpException('Action not exist');
    }


    private function myAudio()
    {
        $response = $this->vkObject->api(
            'audio.get',
            'GET',
            [
                //'owner_id' => $this->getCurrentUser('user_id'),
                'owner_id' => '9154290',
                'count' => 5,
                'offset' => 0,
                'v' => '5.57',
                'no_search' => 1,
            ]
        );

        echo '<pre>';
        print_r($response); exit;

        echo $this->renderView('myAudio', compact('response'));
    }

    private function getWallAudio()
    {
        $response = $this->vkObject->api(
            'wall.get',
            'GET',
            [
                'owner_id' => $this->getCurrentUser('user_id'),
            ]
        );

        $items = [];
        foreach ($response['response'] as $res) {
            var_dump($res);
            $items = $res['items'];
            $history = $items['copy_history'];
            if(isset($history['attachments'])) {
                $attachmets = $res['attachments'];
                foreach($attachmets as $attach) {
                    if (isset($attach['audio'])) {
                        $items[] = $attach['audio'];
                    }
                }
            }
        }

        return $items;
    }

    private function getAudioById($id)
    {
        return $this->vkObject->api(
            'audio.getById',
            'GET',
            [
                'audios' => $this->getCurrentUser('user_id') . '_' . $id
            ]
        );
    }

    private function getCurrentUser($attribute = null)
    {
        $list = $this->vkObject->userAttributes;

        return ($attribute && isset($list[$attribute])) ? $list[$attribute] : $list;
    }
}