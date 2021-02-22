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

        // if usered entered address with slash on the right remove it
        if(strlen($path) > 1) : 
            $path = rtrim($path, '/');
        endif;

        return $path;
    }

    /**
     * This will return http method get or post
     *
     * @return string
     */
    public function method(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * helper function returns true if server method is get
     *
     * @return boolean
     */
    public function isGet() : bool {
        return $this->method() == 'get';
    }

    /**
     * helper function returns true if server method is post
     *
     * @return boolean
     */
    public function isPost() : bool {
        return $this->method() === 'post';        
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
        if($this->isPost()) :
            foreach ($_POST as $key => $value) :
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        if($this->isGet() === 'get') :
            foreach ($_GET as $key => $value) :
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        echo "<pre>";
        var_dump($body);
        echo "</pre>";
        exit;

        return $body;
    }
}