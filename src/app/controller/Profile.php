<?php namespace App\Controller;

class Profile extends BaseController {


    function profile($request, $response, $args) {
        $this->ci->get('model');
        $settings = $this->ci->get('settings');
        $session_information=\App\Model\Users::getCurrentSessionUser();
        $data= $settings['app']+[
            //'user'=>$session_information->toArray(),
            'firstName' => $session_information['first_name'],
            'lastName' => $session_information['last_name'],
            'pageTitle' => 'Dashboard',
            'profileTitle' => '[[Dashboard Title]]d'
            //TODO:'avatarImg' =>$session_information['avatar_url'],
            //TODO:'mesTime' => 'time',
            'genNum' => '1',
            'mesTitle' => 'Message Title',
            'genTex' => 'Text',
            'noteTex' => 'Notification Text',
            'taskTex' => 'Task Name',
            'userName' => 'User Name',
            'userDate' => '10-26-2016',
            'userStat' => 'Online',
            'subTitle' => 'Welcome, ',
            'sideHead' => 'Sidebar Header',
            'actTitle' => 'Activity Title',
            'actDesc' => 'Activity Description',
            'setTitle' => 'Setting',
            'setDesc' => 'Setting Description',
        ];
        return BaseController::renderWithLayout(
            $this->ci->get('renderer'),
            $response,
            'dashboard.phtml',
            'layouts/dashboard-layout.phtml',
            $data
        );
    }
}
