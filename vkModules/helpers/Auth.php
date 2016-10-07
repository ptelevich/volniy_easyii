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

        if ($this->vkObject) {

            //$this->vkObject->setAccessToken(null); exit;
            //$this->vkObject->setAccessToken((new OAuthToken)->setToken('ed0a039e6ea0aac9e3ef62289e2470c34d9f6cf303b784a5fde5061a3d3b433dd7bdb8cbbb4752ce71f3c'));
            $auth = new OAuthToken();
            $auth->setToken('2dd2778883ac834f1972c7f80f3576ebcbf1d5f69521fec05158c62a9d083535273f5f6b4cdcd95960fe7');
            $this->vkObject->setAccessToken($auth);
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

                var_dump($buildUrl); exit;

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