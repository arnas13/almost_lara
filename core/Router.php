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
        * ['/about' => function return,],
     * ],
     * 
     * ];
     * 
     * @var array
     */
    protected array $routes = [];
    public Request $request;

    public function __construct($request)
    {
        $this->request = $request;
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
     * Executes user function if it is set in routes array
     *
     */
    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        

        // print "<pre>";
        // var_dump($this->routes);
        // var_dump($path);
        // var_dump($method);
        // print "</pre>";
        // exit();

        // trying to run a route from routes array 
        $callback = $this->routes[$method][$path] ?? false;
        // if there is no such route added, we say it doesn't exist
        if ($callback === false) : 
            // 404
            Application::$app->response->setResponseCode(404); 
            print "Page doesn't exist";
            die();
        endif;

        // if our callback value is string
        // $app->router->get('/about', 'about');
        if(is_string($callback)) :
            return $this->renderView($callback);
        endif;

        // page does exist, we call user function
        return call_user_func($callback);

    }

    /**
     * Renders the page and applies the layout
     *
     * @param string $view
     * @return string / string []
     */
    public function renderView(string $view) {
        $layout = $this->layoutContent();
        $page = $this->pageContent($view);

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
        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR."/view/layout/main.php";
        // stop and return buffering
        return ob_get_clean();
    }

    /**
     * Returns only the given page HTML content
     *
     * @param [type] $view
     * @return void
     */
    protected function pageContent($view) {
        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR."/view/$view.php";
        // stop and return buffering
        return ob_get_clean();
    }
}