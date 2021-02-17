<?php 

namespace app\core;


class Request {
    /**
     * 
     * Get user page form url
     * 
     * [REQUEST_URI] => /todos?id=5
     * extract /todos
     *   
     * @return false/mixed/string
     */

    public function getPath() : string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $questionPosition = strpos($path, '?');

        if($questionPosition !== false) : 
            $path = substr($path, 0, $questionPosition);
        endif;

        return $path;
    }
}