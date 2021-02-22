<?php


namespace app\core;

use app\model\UserModel;

/**
 * Respossible for handling login and register.
 *
 * Class AuthController
 * @package app\core
 */
class AuthController extends Controller
{
    public Validation $vld;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->vld = new Validation();
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // have ability to change laout
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if ($request->isGet()) :
//            $this->setLayout('auth');

            // create data
            $data = [
                'name'      => '',
                'email'     => '',
                'password'  => '',
                'confirmPassword' => '',
                'errors' => [
                    'nameErr'      => '',
                    'emailErr'     => '',
                    'passwordErr'  => '',
                    'confirmPasswordErr' => '',
                ],
                'currentPage' => 'register',
            ];



            return $this->render('register', $data);
        endif;

        if ($request->isPost()) :

            // reques is post and we need to pull user data
            $data = $request->getBody();

            $data['errors']['nameErr'] = $this->vld->validateName($data['name']);

            $data['errors']['emailErr'] = $this->vld->validateEmail($data['email'], $this->userModel);

            $data['errors']['passwordErr'] = $this->vld->validatePassword($data['password'], 6, 10);

            $data['errors']['confirmPasswordErr'] = $this->vld->confirmPassword($data['confirmPassword']);

            // if there are no errors
            if ($this->vld->ifEmptyArr($data['errors'])) :


                // hash password // save way to store pass
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // create user
                if ($this->userModel->register($data)) {
                    // success user added
                    // set flash msg
//                    flash('register_success', 'You have registered successfully');
                    // header("Location: " . URLROOT . "/users/login");
//                    redirect('/login');
                } else {
                    die('Something went wrong in adding user to db');
                }

            endif;




            return $this->render('register', $data);
        endif;
    }
}