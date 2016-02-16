<?php
/**
 * Created by PhpStorm.
 * User: wap26
 * Date: 27/01/16
 * Time: 10:21
 */

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider;

//
// Application setup
//
$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/Views',
));

$app->register(new Provider\DoctrineServiceProvider());
$app->register(new Provider\SecurityServiceProvider());
$app->register(new Provider\RememberMeServiceProvider());
$app->register(new Provider\SessionServiceProvider());
$app->register(new Provider\ServiceControllerServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());
$app->register(new Provider\SwiftmailerServiceProvider());
$app->register(new Provider\HttpFragmentServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('fr'),
));

$simpleUserProvider = new SimpleUser\UserServiceProvider();
$app->register($simpleUserProvider);

$app->register(new Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    'profiler.mount_prefix' => '/_profiler', // this is the default
));

//
// Controllers
//
// Simple user controller routes:
$app->mount('/user', $simpleUserProvider);




$app->get(
    '/',
    'UserPart\Controller\HomeController::Home'
)->bind('Home');


$app->get(
    '/Login',
    'UserPart\Controller\User\Login\LoginController::Login'
)->bind('Login');






//
// Configuration SimpleUser
//

// SimpleUser options. See config reference below for details.
$app['user.options'] = array();

// Security config. See http://silex.sensiolabs.org/doc/providers/security.html for details.
$app['security.firewalls'] = array(
    /* // Ensure that the login page is accessible to all, if you set anonymous => false below.
    'login' => array(
        'pattern' => '^/user/login$',
    ), */
    'secured_area' => array(
        'pattern' => '^.*$',
        'anonymous' => true,
        'remember_me' => array(),
        'form' => array(
            'login_path' => '/user/login',
            'check_path' => '/user/login_check',
        ),
        'logout' => array(
            'logout_path' => '/user/logout2',
        ),
        'users' => $app->share(function($app) { return $app['user.manager']; }),
    ),
);

//Template SimpleUser

$app['user.options'] = array(
    // ...
    'templates' => array(
        'layout' => 'LayoutView.html.twig',
    ),
    'editCustomFields' => array(
            'twitterUsername' => 'Twitter username',
    ),
);














// Mailer config. See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
$app['swiftmailer.options'] = array();




//
//DATA BASE DOCTRINE
//




// Database config. See http://silex.sensiolabs.org/doc/providers/doctrine.html
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'doctrine_test',
    'user' => 'root',
    'password' => 'troiswa',
);



//
//FIN
//

$app['debug'] = true;

$app->run();