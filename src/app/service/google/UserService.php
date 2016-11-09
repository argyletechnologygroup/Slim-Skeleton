<?php
namespace App\Service\Google;

use SlimApi\OAuth\UserServiceInterface;
use OAuth\Common\Service\ServiceInterface;

///@DEPRECATED
class UserService implements UserServiceInterface {

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser(ServiceInterface $googleService)
    {
        // request the user information from google
        // could go further with this and check org/team membership
        $user = json_decode($googleService->request('user'), true);

        // try to find user by the oauth server's user id,
        // best way since oauth token might have been invalidated
        $model  = $this->userModel->firstOrNew(['remote_id' => $user['id']]);
        $model->oauth_token = $googleService->getStorage()->retrieveAccessToken('google')->getAccessToken();
        $model->token       = App\Utils\TokenGenerator::getToken();
        $model->save();
        return $model;
    }

    public function findOrNew($authToken)
    {
        // retrieve the user by the authToken provided
        // this could also be from some fast access redis db
        $users = $this->userModel->byToken($authToken)->get();
        $user = $users->first();
        // or return a blank entry if it doesn't exist
        return ($user ?: new $this->userModel);
    }
}
