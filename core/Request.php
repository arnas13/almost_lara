<?php 

namespace app\core;

/**
 * 
 * Get user page form uri
 * 
 * [REQUEST_URI] => /AlmostLara/todos?id=5
 * extract /todos
 * 
 * Class Request 
 * @package app\core
 */
class Request {
    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/AlmostLara/';
        $questionPosition = strpos($path, '?');
        print "<pre>";
        var_dump($questionPosition);
        print "</pre>";
        exit;
    }
}