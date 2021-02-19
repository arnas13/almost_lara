<?php 

namespace app\core;

/**
 * Class Router 
 * 
 * This is where we call controllers and methods
 * 
 * @package app\core
 */
class Router {
    /**
     * This will hold all routes
     * 
     * routes [
     * ['get' => [
        * ['/' => function return,],
        * ['/about' => 'about' ,],
     * ],  
     * ['post' => [
        * ['/' => function return,],
        * ['/contact' => function return,],
     * ],
     * 
     * ];
     * 
     * @var array
     */
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Add get route and callback to routes array
     *
     * @param string $path
     * @param [type] $callback
     */
    public function get($path, $callback) {
        $this->routes['get'][$path] =  $callback;
    }

    /**
     * This creates post path and handling in route array.
     *
     * @param [type] $path
     * @param [type] $callback
     * @return void
     */
    public function post($path, $callback) {
        $this->routes['post'][$path] =  $callback;
    }

    /**
     * Executes user function if it is set in routes array
     *
     */
    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->method();
        

        // trying to run a route from routes array 
        $callback = $this->routes[$method][$path] ?? false;
        // if there is no such route added, we say it doesn't exist
        if ($callback === false) : 
            // 404
            $this->response->setResponseCode(404); 
            return $this->renderView('_404');
        endif;

        // if our callback value is string
        // $app->router->get('/about', 'about');
        if(is_string($callback)) :
            return $this->renderView($callback);
        endif;

        // if our callback is array we handle it with class instance
        if (is_array($callback)) :
            $instance = new $callback[0];
            Application::$app->controller = $instance;
            $callback[0] = Application::$app->controller;
        endif;

        // print "<pre>";
        // var_dump($callback);
        // var_dump($path);
        // var_dump($method);
        // print "</pre>";
        // exit();

        // page does exist, we call user function
        return call_user_func($callback, $this->request);

    }

    /**
     * Renders the page and applies the layout
     *
     * @param string $view
     * @return string / string []
     */
    public function renderView(string $view, array $params = []) {
        $layout = $this->layoutContent();
        $page = $this->pageContent($view, $params);

        // take layout and replace the content with the $page content
        return str_replace('{{content}}', $page, $layout);

        // 
    }

    /**
     * Returns the layout HTML content
     *
     * @return false / string
     */
    protected function layoutContent () {
        $layout = Application::$app->controller->layout;
        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR."/view/layout/$layout.php";
        // stop and return buffering
        return ob_get_clean();
    }

    /**
     * Returns only the given page HTML content
     *
     * @param [type] $view
     * @return void
     */
    protected function pageContent($view, $params) {
        // a smart way of creating variables dinamically        
        // $name = $params['name'];

        foreach($params as $key => $value) :
            $$key = $value;
        endforeach;


        // print "<pre>";
        // print_r($params);        
        // print "</pre>";
        // exit();

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR."/view/$view.php";
        // stop and return buffering
        return ob_get_clean();
    }

}