<?php
namespace App\Model;
use \App\Model\Database\User;

class Users {

    /**
     * An alias of 'whereToken'
     * @see whereToken
     */
    public function byToken($token, $type = 'google')
    {
        return User::whereToken($token, $type);
    }

    /**
     * Get the user by their assosiated oauth token.
     */
    public function whereToken($token, $type = 'google')
    {
        switch($type){
            case'google': {
                return User::google_token()->where('access_token', '=', $token)->user();
            }
            default:{
                return User::where('1', '=', '0');
            }
        }
        return User::hasOne('App\Model\GoogleToken');
    }

    public static function getCurrentSessionUser()
    {
        $identifier = \Hybrid_Auth::storage()->get('user');
        return User::where('identifier','=', $identifier)->first();
    }

}
