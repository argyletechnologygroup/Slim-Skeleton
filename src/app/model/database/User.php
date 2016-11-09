<?php
namespace App\Model\Database;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * Get the google token associated with the user.
     */
    public function google_token()
    {
        return $this->hasOne('App\Model\GoogleToken');
    }
    
    /**
     * Get the users that have this role.
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Model\Database\Roles');
    }
}
