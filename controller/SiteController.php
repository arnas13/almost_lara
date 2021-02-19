<?php 

namespace app\controller;

use app\core\Application;
use app\core\Controller;

class SiteController extends Controller {
    /**
     * This handles Home page get request
     *
     * @return string
     */
    public function home(){
        $params = [
            'name' => "AlmostLara",
            'subtitle' => "This is a nice way to learn PHP"
        ];

        return $this->render('home', $params);
    }
    /**
     * This serves the about form view
     *
     * @return string
     */
    public function about() {
        $params = [
            'version' => '1.0.0'
        ];
        // lets render view
        return $this->render('about', $params);
    }

    /**
     * This serves the contact form view
     *
     * @return string
     */
    public function contact() {
        // lets render view
        return $this->render('contact');
    }

    /**
     * This is were we handle post contact form.
     *
     * @return string
     */
    public function handleContact() {
        return "handling form from site controller handle form method";
    }
    
}
