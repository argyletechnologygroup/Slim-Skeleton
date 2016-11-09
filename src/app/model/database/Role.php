<?php
namespace App\Model\Database;

class Role extends Illuminate\Database\Eloquent\Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
    
    /**
     * Get the users that have this role.
     */
    public function users()
    {
        return $this->belongsToMany('\App\Model\Database\User');
    }
}