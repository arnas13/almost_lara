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

    /**
     * This will return http method get or post
     *
     * @return string
     */
    public function getMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    /**
     * Sanitize get and post arrays with html special chars
     *
     * @return array
     */
    public function getBody() {
        // store clean values
        $body = [];

        // what type of request
        if($this->getMethod() === 'post') :
            foreach ($_POST as $key => $value) :
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        if($this->getMethod() === 'get') :
            foreach ($_GET as $key => $value) :
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        return $body;
    }
}