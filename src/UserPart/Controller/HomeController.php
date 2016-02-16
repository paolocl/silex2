<?php


namespace UserPart\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController
    {
        public function Home(Request $request, Application $app)
        {
            $photos = json_decode(file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=a57a5dab99811e14758bd3882551dfb2&format=json&nojsoncallback=1&tags=tennis,roger&min_taken_date=2016-01-27'), true);



            return $app['twig']->render('HomeView.html.twig', ['photos' => $photos ]);
        }
    }
