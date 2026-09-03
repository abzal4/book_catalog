<?php

class UserValidator
{
    public static function validateName($name)
    {
        if (!is_string($name)) {
            return false;
        }
        if (trim($name) == '') {
            return false;
        }
        return trim($name);
    }

    public static function validateLogin($login)
    {
        if (!is_string($login)) {
            return false;
        }
        if (trim($login) == '') {
            return false;
        }
        if (mb_strlen($login) < 2 || mb_strlen($login) > 50) {
            return false;
        }
        return trim($login);
    }

    public static function validatePassword($password)
    {
        if (trim($password) == '') {
            return false;
        } 
        if (mb_strlen($password) < 5 || mb_strlen($password) > 50) {
            return false;
        }
        return $password;
    }
}