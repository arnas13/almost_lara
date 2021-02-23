<?php


namespace app\controller;


use app\core\Controller;

class PostsController extends Controller
{
    public function index()
    {
        $params = [];
        return $this->render('posts/posts');
    }

}