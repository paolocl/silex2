<?php

namespace UserPart\Controller\User\Login;

use Silex\Application;

    class LoginController
    {
        public function Login(Application $app)
        {
            return $app['twig']->render(
                'User\Login\LoginView.html.twig',
                array(
                    'name' => 'hello',
                )
            );
        }
    }
