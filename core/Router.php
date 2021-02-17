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
        * ['/about' => function return,],
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

    public function get($path, $callback) {
        $this->routes['get'][$path] =  $callback;
    }

    public function resolve() {
        print "<pre>";
        var_dump($this->request->getPath());
        print "</pre>";
        exit;
    }
}