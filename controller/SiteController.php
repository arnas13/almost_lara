<?php 

namespace app\controller;

use app\core\Application;

class SiteController {
    /**
     * This handles Home page get request
     *
     * @return string
     */
    public static function home(){
        $params = [
            'name' => "AlmostLara",
            'subtitle' => "This is a nice way to learn PHP"
        ];

        return Application::$app->router->renderView('home', $params);
    }
    /**
     * This serves the about form view
     *
     * @return string
     */
    public static function about() {
        $params = [
            'version' => '1.0.0'
        ];
        // lets render view
        return Application::$app->router->renderView('about', $params);
    }

    /**
     * This serves the contact form view
     *
     * @return string
     */
    public static function contact() {
        // lets render view
        return Application::$app->router->renderView('contact');
    }

    /**
     * This is were we handle post contact form.
     *
     * @return string
     */
    public static function handleContact() {
        return "handling form from site controller handle form method";
    }
    
}
