<?php 

namespace app\core;


Class Validation
{
    private string $password;
  
    /**
     * check if every array value is empty
     *
     * @param array $arr
     * @return bool
     */
    public function ifEmptyArr($arr)
    {
        // check if all values of array is empty
        foreach ($arr as $errorValue) {
            if (!empty($errorValue)) {
                return false;
            }
        }
        return true;
    }
   

    /**
     * check if given string is empty. Returns message if empty.
     *
     * @param string $field
     * @param string $msg
     * @return string
     */
    public function validateEmpty($field, $msg)
    {
        return empty($field) ? $msg : '';
    }

    /**
     * if field is empty we return message, else we return empty string.
     *
     * @param string $field
     * @return string
     */
    public function validateName($field)
    {
        // Validate Name 
        if (empty($field)) return "Please enter your Name";

        if (!preg_match("/^[a-z ,.'-]+$/i", $field)) return "Name must only contain Name characters";

        return ''; //falsy
    }

    /**
     * Validate rules and test for Email in registration
     *
     * @param string $field
     * @param UserModel $userModel
     * @return string
     */
    public function validateEmail($field, &$userModel = null)
    {
        // validate empty 
        if (empty($field)) return "Please enter Your Email";

        // check email format
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Please check your email";

        if($userModel !== null) : 
            // if email already exists
            if ($userModel->findUserByEmail($field)) return 'Email already taken';
        endif;
        return '';
    }

    /**
     * Validate rules and test for Email in login
     *
     * @param string $field
     * @param UserModel $userModel
     * @return string
     */
    public function validateLoginEmail($field, &$userModel)
    {
        // validate empty 
        if (empty($field)) return "Please enter Your Email";

        // check email format
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Please check your email";

        // if email already exists
        if (!$userModel->findUserByEmail($field)) return 'Email not found';

        return '';
    }

    /**
     * Validate rules and test for Password 
     *
     * @param string $passField
     * @param int $min
     * @param int $max
     * @return string
     */
    public function validatePassword($passField, $min, $max)
    {
        // validate empty 
        if (empty($passField)) return "Please enter a password";

        // save password for later
        $this->password = $passField;

        // if pass length is les then min
        if (strlen($passField) < $min) return "Password must be more than $min characters length";

        // if pass length is more then max
        if (strlen($passField) > $max) return "Password must be less than $max characters length";

        // check password strength
        if (!preg_match("#[0-9]+#", $passField)) return "Password must contain at least one number";

        if (!preg_match("#[a-z]+#", $passField)) return "Password must include at least one letter!";

        if (!preg_match("#[A-Z]+#", $passField)) return "Password must include at least one Capital letter!";

        // if (!preg_match("#\W+#", $passField)) return "Password must include at least one symbol!";

        return '';
    }

    /**
     * Checks if given value is same as previously entered password
     *  using validatePassword
     *
     * @param string $repeatField
     * @return string
     */
    public function confirmPassword($repeatField)
    {
        // validate empty 
        if (empty($repeatField)) return "Please repeat a password";

        if (!$this->password) return 'no password saved';

        if ($repeatField !== $this->password) return "Password must match";

        return '';
    }
}