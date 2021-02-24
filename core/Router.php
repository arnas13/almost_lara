<?php


namespace app\core;

/**
 * Class Router
 *
 * This is where we call controllers and methods
 *
 * @package app\core
 */
class Router
{
    /**
     * This will hold all routes.
     *
     * routes [
     * ['get'  => [
     *  ['/' => function return,],
     *  ['/about' => 'about',],
     * ],
     * ['post' => [
     *  ['/' => function return,],
     *  ['/contact' => function return,],
     * ]]
     * ]
     *
     *
     * ];
     *
     * @var array
     */
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Add get route and callback fn to routes array
     *
     * @param string $path
     * @param $callback
     */
    public function get($path, $callback)
    {
        // 12345678910
        //"/post/{id}"
        if (strpos($path, '{')):
            $startPos = strpos($path, '{');
            $endPos = strpos($path, '}');
            $argName = substr($path, $startPos + 1, $endPos - $startPos - 1);
            $callback['urlParamName'] = $argName;
            $path = substr($path, 0, $startPos -1);

//        echo "<pre>";
//        var_dump($path);
////        var_dump($this->routes);
//        echo "</pre>";
//        exit;

        endif;


        $this->routes['get'][$path] = $callback;
    }

    /**
     * This creates post path and handling in routes array.
     *
     * @param $path
     * @param $callback
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Executes user function if it is set in routes array
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        // path = "/post/1" take argument value 1
        // path = "/post" skip path argument take
        // extract 1

        $pathArr = explode('/', ltrim($path, '/'));

        if (count($pathArr) > 1) :
            $path = '/' . $pathArr[0];
            $urlParam['value'] = $pathArr[1];
        endif;



        // trying to run a route from routes array
        $callback = $this->routes[$method][$path] ?? false;

//        echo "<pre>";
//        print_r($this->routes);
//        echo "</pre>";
//        exit;

        // if there is no such route added, we say not exist
        if ($callback === false) :
            // 404
            $this->response->setResponseCode(404);
            return $this->renderView('_404');
        endif;

        // if our callback value is string
        // $app->router->get('/about', 'about');
        if (is_string($callback)) :
            return $this->renderView($callback);
        endif;

        // if our callback is array we handle it whith class instance
        if (is_array($callback)) :
            $instance = new $callback[0];
            Application::$app->controller = $instance;
            $callback[0] = Application::$app->controller;

            // check if we have url arguments in callback array
            if (isset($callback['urlParamName'])) :
                //     [0] => app\controller\PostsController
//                    [1] => post
//                    [urlParamName] => id
                $urlParam['name'] = $callback['urlParamName'];
                // make call back array with 2 members
                array_splice($callback, 2, 1);
            endif;

        endif;


        // page dose exsist we call user function
//        $urlParam = [
//            'value' => 32,
//            'name' => 'id'
//        ];
        return call_user_func($callback, $this->request, $urlParam ?? null);

    }

    /**
     * Renders the page and applies the layout
     *
     * @param string $view
     * @return string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        $layout = $this->layoutContent();
        $page = $this->pageContent($view, $params);
//        echo $page;
        // take layout and replace the {{content}} with the $page content
        return str_replace('{{content}}', $page, $layout);

        //
    }

    /**
     * Returns the layout HTML content
     *
     * @return false|string
     */
    protected function layoutContent()
    {
        if (isset(Application::$app->controller)) :
            $layout = Application::$app->controller->layout;
        else :
            $layout = 'main';
        endif;

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/layout/$layout.php";
        // stop and return buffering
        return ob_get_clean();

    }

    /**
     * Returns only the given page HTML content
     *
     * @param $view
     * @param $params
     * @return false|string
     */
    protected function pageContent($view, $params)
    {
//        $params = [
//            'name' => "AlmostLara",
//            'subtitle' => "This is a nice way to learn PHP"
//        ];
        // a smart way of creating variables dinamically
        // $name = $params['name'];
        foreach ($params as $key => $value) :
            $$key = $value; // name = AlmostLara // $name = AlmostLara
        endforeach;

        // start buffering
        ob_start();
        include_once Application::$ROOT_DIR . "/view/$view.php";
        // stop and return buffering
        return ob_get_clean();
    }



}