<?php


namespace app\core;


class Validation
{
    private $password;

    /**
     * Checks if every array value is empty
     * @param array $arr
     * @return bool
     */
    public function ifEmptyArray($arr)
    {
        foreach ($arr as $value){
            if (!empty($value)) return false;
        }
        return true;
    }

    /**
     * Checks if given field is empty. Returns given message if empty.
     *
     * @param string $field
     * @param string $msg
     * @return string
     */
    public function validateEmpty($field, string $msg)
    {
        return empty($field) ? $msg : '';
    }

    /**
     * Validates Name or Surname field
     *
     * @param $field
     * @return string
     */
    public function validateNameSurname($field, $message)
    {
        if (empty($field)) return $message;
        if (!preg_match("/^[a-z ,.'-ĄČĘĖĮŠŲŪŽ]+$/i", $field)) return "Field Must Contain Only Letters";
        if (preg_match('/[0-9]+/', $field)) return "Numbers Are Not Allowed";
        if (strlen($field)>40) return "Max Symbol Count 40";
        return '';
    }

    /**
     * Validates email field
     *
     * @param $field
     * @return string
     */
    public function validateEmail($field, &$userModel = null)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email Is Not Correct, Please Use Correct Format";
        if ($userModel !== null) :
            if ($userModel->findUserByEmail($field)) return "Email Already Taken, Use Another Email";
        endif;

        return '';
    }

    /**
     * Validates password field
     *
     * @param $field
     * @return string
     */
    public function validatePassword($field)
    {
        if (empty($field)) return "Please Enter Your Password";
        if (strlen($field) < 6) return "Password Must Be Minimum 6 Characters Long";
        if (strlen($field) > 40) return "Password Must Be Maximum 40 Characters Long";
        if(!preg_match("#[0-9]+#", $field)) return "Password Must Include At Least One Number!";
        if(!preg_match("#[a-z]+#", $field)) return "Password Must Include At Least One Letter!";
        if(!preg_match("#[A-Z]+#", $field)) return "Password Must Include At Least One Capital Letter!";
        $this->password = $field;
        return '';
    }

    /**
     * Validates confirm password field.
     *
     * @param $field
     * @return string
     */
    public function confirmPassword($field)
    {
        if (empty($field)) return "Please Repeat Your Password";
        if (!$this->password) return "No Password Found";
        if ($field !== $this->password) return "Passwords Must Match";
        return '';
    }

    /**
     * Validate phone field.
     *
     * @param $field
     * @return string
     */
    public function validatePhone($field)
    {
        if(strlen($field)>0 && preg_match("/^[^0-9]*$/", $field)) return "Only Numbers Allowed!";
        return '';
    }

    /**
     * Validates address field.
     *
     * @param $field
     * @return string
     */
    public function validateAddress($field)
    {
        if (strlen($field)>=60) return "Maximum Symbol Count 60";
        return '';
    }

    /**
     * Validates postal code field.
     *
     * @param $field
     * @return string
     */
    public function validatePostalCode($field)
    {
        if (strlen($field)>=10) return "Maximum Symbol Count 10";
        return '';
    }

    /**
     * Validates login email field.
     *
     * @param $field
     * @param $userModel
     * @return string
     */
    public function validateLoginEmail($field, &$userModel)
    {
        if (empty($field)) return "Please Enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email Is Not Correct, Please Use Correct Format";
        if (!$userModel->findUserByEmail($field)) return "Email Not Found";
        return '';
    }

    public function validateEditEmail($field, &$userModel, $oldEmail)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email Is Not Correct, Please Use Correct Format";
        if ($field !== $oldEmail){
            if ($userModel->findUserByEmail($field)) return "Email already taken";
        }
        return '';
    }

    /**
     * Validates comment length.
     *
     * @param $field
     * @return string
     */
    public function validateBody($field)
    {
        if (empty($field)) return "Comment Cannot Be Empty";
        if (strlen($field)>500) return "Max Characters Count 500!";
        return '';
    }

    public function validateURL($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        } else {
            return ("It is not a valid URL, please enter a correct URL");
        }
    }

    public function validateItemType($type)
    {
        if($type === null) {
            return 'Select item type, input field can not bet unselected';
        } else {
            return '';
        }
    }
}
