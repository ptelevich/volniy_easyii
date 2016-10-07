<?php
namespace fedoskin\vkModules\helpers;

use Yii;
use yii\authclient\clients\VKontakte;
use yii\authclient\OAuthToken;

/**
 * @property VKontakte $vkObject
*/
class Auth
{
    public $clientId;
    public $clientSecret;

    /**
     * Scope of modules that need for API request
     * @example
     * public $scope = 'friends,photos,pages,wall,groups,email,stats,ads,offline,notifications,messages,nohttps'
     */
    public $scope = 'friends,wall,groups,email,audio';

    protected $vkObject;

    public function __construct()
    {
        $this->vkObject = new VKontakte();
    }

    protected function makeOAuth()
    {
        $this->vkObject->clientId = $this->clientId;
        $this->vkObject->clientSecret = $this->clientSecret;
        $this->vkObject->scope = $this->scope;
        $this->vkObject->version = '5.57';

        if ($this->vkObject) {

            //$this->vkObject->setAccessToken(null); exit;
            $accessToken = $this->vkObject->getAccessToken();
            $requestCode = Yii::$app->request->get('code', null);
            if (!$accessToken || $requestCode) {

                if ($requestCode) {
                    if($accessToken) {
                        $url = Yii::$app->controller->id;
                        $url .= '/';
                        $url .= Yii::$app->controller->action->id;
                        $action = Yii::$app->request->get('action', null);
                        if ($action) {
                            $url .= '?action='.$action;
                        }
                        header('Location: /' . $url);
                        exit;
                    }
                    $oAuthToken = $this->vkObject->fetchAccessToken($requestCode);
                    $oAuthToken->setToken($oAuthToken->getToken());
                    $this->vkObject->setAccessToken($oAuthToken);
                }

                $buildUrl = $this->vkObject->buildAuthUrl();

                header('Location: ' . $buildUrl);
                exit;
            }

            return true;
        }

        return false;
    }

    public function getVkObject()
    {
        return $this->_vkObject;
    }
}