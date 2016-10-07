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

    // https://oauth.vk.com/authorize?client_id=3682744&scope=wall,offline,audio&redirect_uri=https://oauth.vk.com/blank.html&display=page&v=5.7&response_type=token
    // https://oauth.vk.com/authorize?client_id=3087106&scope=wall,offline,audio&redirect_uri=https://oauth.vk.com/blank.html&display=page&v=5.7&response_type=token
    protected function makeOAuth()
    {
        $this->vkObject->clientId = $this->clientId;
        $this->vkObject->clientSecret = $this->clientSecret;
        $this->vkObject->scope = $this->scope;

        if ($this->vkObject) {

            //$this->vkObject->setAccessToken(null); exit;
            //$this->vkObject->setAccessToken((new OAuthToken)->setToken('ed0a039e6ea0aac9e3ef62289e2470c34d9f6cf303b784a5fde5061a3d3b433dd7bdb8cbbb4752ce71f3c'));
            $auth = new OAuthToken();
            $auth->setToken('280f86c739e82ff4e18403685be6a3e5feaa09f61e217fa2a331291f0e8b28a301fd1dc7c8f483feee86e');
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