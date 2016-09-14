<?php

namespace app\components;

use Yii;
use yii\authclient\clients\VKontakte;
use yii\authclient\OAuthToken;
use yii\base\Component;

/**
 * @property VKontakte $_vkObject
*/
class VkHelper extends Component
{
    /**
     * @var VKontakte|array access token instance or its array configuration.
     */
    private $_vkObject;
    private $_logs = [];

    public function __construct()
    {
        $this->_vkObject = Yii::$app->authClientCollection->getClient('vkontakte');
        if ($this->_makeOAuth()) {
            $this->_setLog(['mess' => 'success make OAuth']);
        }
    }

    public function getMyAudio()
    {
        return $this->_vkObject->api(
            'audio.get',
            'GET',
            [
                'owner_id' => $this->getCurrentUser('user_id')
            ]
        );
    }

    public function getWallAudio()
    {
        $response = $this->_vkObject->api(
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

    public function getAudioById($id)
    {
        return $this->_vkObject->api(
            'audio.getById',
            'GET',
            [
                'audios' => $this->getCurrentUser('user_id') . '_' . $id
            ]
        );
    }

    private function getCurrentUser($attribute = null)
    {
        $list = $this->_vkObject->userAttributes;

        return ($attribute && isset($list[$attribute])) ? $list[$attribute] : $list;
    }

    private function _setLog($data)
    {
        if (isset($data['mess'])) {
            $this->_logs[] = $data['mess'];
        }
    }

    /** @var $_vkObject VKontakte */
    private function _makeOAuth()
    {
        if ($this->_vkObject) {

            $accessToken = $this->_vkObject->getAccessToken();
            if (!$accessToken) {
                $requestCode = Yii::$app->request->get('code', null);

                if ($requestCode) {
                    $oAuthToken = $this->_vkObject->fetchAccessToken($requestCode);
                    $oAuthToken->setToken($oAuthToken->getToken());
                    $this->_vkObject->setAccessToken($oAuthToken);
                    exit;
                }

                $buildUrl = $this->_vkObject->buildAuthUrl();

                return Yii::$app->controller->redirect($buildUrl);
            }

            return true;
        }

        return false;
    }
}