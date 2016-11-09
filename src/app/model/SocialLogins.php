<?php
namespace App\Model;
use App\Model\Database\User;

class SocialLogins
{
    /** @var object Database connection */
    private $user;

    /**
     * Check if a HybridAuth identifier already exists in DB
     *
     * @param int $identifier
     *
     * @return bool
     */
    public function identifier_exists($identifier)
    {
        return (User::where('identifier', '=', $identifier)->count()) > 0;
    }

    /**
     * Save users record to the database.
     *
     * @param string $identifier user's unique identifier
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @param string $avatar_url
     *
     * @return created user object
     */
    public function register_user( $identifier, $email, $first_name, $last_name, $avatar_url )
    {
        $user = User::create();
        $user->identifier = $identifier;
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->avatar_url = $avatar_url;
        $user->save();
        return $user;
    }

    /**
     * Create user login session
     *
     * @param int $identifier
     */
    public function login_user($identifier)
    {
        \Hybrid_Auth::storage()->set('user', $identifier);
    }

    /** Destroy user login session */
    public function logout_user()
    {
        \Hybrid_Auth::storage()->set( 'user', null );
    }

    /**
     * Return user's first name.
     *
     * @param int $identifier
     *
     * @return string
     */
    public function getFirstName( $identifier )
    {
        if ( ! isset( $identifier )) {
            return;
        }

        $user = User::select('first_name')->where('identifier','=', $identifier)->get();
        return $user['first_name'];
    }

    /**
     * Return user's last name.
     *
     * @param int $identifier
     *
     * @return string
     */
    public function getLastName( $identifier )
    {
        if ( ! isset( $identifier )) {
            return;
        }
        $user = User::select('last_name')->where('identifier','=', $identifier)->get();
        return $user['last_name'];
    }

    /**
     * Return user's email address
     *
     * @param int $identifier
     *
     * @return string
     */
    public function getEmail( $identifier )
    {
        if ( ! isset( $identifier )) {
            return;
        }
        $user = User::select('email')->where('identifier','=', $identifier)->get();
        return $user['email'];
    }

    /**
     * Return the URL of user's avatar
     *
     * @param int $identifier
     *
     * @return string
     */
    public function getAvatarUrl( $identifier )
    {
        if ( ! isset( $identifier )) {
            return;
        }
        $user = User::select('avatar_url')->where('identifier','=', $identifier)->get();
        return $user['avatar_url'];
    }
}