<?php namespace App\Controller;
use \Hybrid_Endpoint;
use \Hybrid_Auth;

class Authentication extends BaseController {

    function getLogin($request, $response, $args) {
        return \App\Controller\BaseController::renderWithLayout(
            $this->ci->get('renderer'),
            $response,
            'login.phtml',
            'layouts/simple-layout.phtml',
            ['allowUsernamePasswordLogin' => false]
        );
    }

    function postLogin($request, $response, $args) {
        return $response->withRedirect( '/login/?err=2' );
    }

    function oauthLogin($request, $response, $args) {
        //TODO get some error handling in
        $logger = $this->logger;
        $logger->addDebug("Logging in user with '{$args['idp']}'");
        $adapter    = $this->ci->get('hybridauth')->authenticate( ucwords( $args['idp'] ) );
        $socialauth = $this->ci->get('socialauth');
        $user_profile = $adapter->getUserProfile();
        if (empty( $user_profile )) {
            $logger->addDebug("Unable to log in user with '{$args['idp']}'");
            return $response->withRedirect( '/login/?err=1' );
        }
        $identifier = $user_profile->identifier;
        if ($socialauth->identifier_exists( $identifier )) {
            $logger->addDebug("Logging in existing user with '{$args['idp']}' login");
            $socialauth->login_user( $identifier );
            return $response->withRedirect( '/welcome/' );
        } else {
            $logger->addDebug("Regisering new user with '{$args['idp']}' login");
            $register = $socialauth->register_user(
                $identifier,
                $user_profile->email,
                $user_profile->firstName,
                $user_profile->lastName,
                $user_profile->photoURL
            );
            if ($register) {
                $logger->addDebug("Logging in new user with '{$args['idp']}' login");
                $socialauth->login_user( $identifier );
                return $response->withRedirect( '/welcome/' );
            }
            else{
                $logger->addError("Failed regisering new user with '{$args['idp']}' login");
                return $response->withRedirect( '/login/?err=2' );
            }
        }
    }

    function logout($request, $response, $args) {
        $this->ci->get('hybridauth');
        $this->ci->get('socialauth')->logout_user();
        Hybrid_Auth::logoutAllProviders();
        return $response->withRedirect( '/login/' );
    }

    function welcome($request, $response, $args) {
        //TODO make a nice welcome landing page
        return $response->withRedirect( '/auth/dashboard/' );
    }

    function oauth2endpoint($request, $response, $args) {
        Hybrid_Endpoint::process();
    }

    function hybrid($request, $response, $args) {
        return $response->withRedirect( '/oauth2endpoint/' );
    }
}
 







