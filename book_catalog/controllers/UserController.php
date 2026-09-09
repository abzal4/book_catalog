<?php

require_once __DIR__ .'/../functions/users.php';
require_once __DIR__ .'/../validators/IdValidator.php';
require_once __DIR__ .'/../validators/UserValidator.php';

class UserController {
    public static function getById($conn, $userId)
    {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'message' => 'Неправильный ID!'
            ], JSON_UNESCAPED_UNICODE);
        }
        $user = get_user_by_id($conn, $userId);
        if (!$user) {
            http_response_code(404);
            return json_encode([
                'success' => false,
                'message' => 'Пользователь не найден!'
            ], JSON_UNESCAPED_UNICODE);
        }
        http_response_code(200);
        return json_encode([
            'success' => true,
            'data' => $user
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function getAll($conn) {
        $users = get_users($conn);
        if (!$users) {
            http_response_code(200);
            return json_encode([
                'success' => true,
                "data" => []
            ], JSON_UNESCAPED_UNICODE);
        } 
        http_response_code(200);
        return json_encode([
            'success' => true,
            'data' => $users
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function getAmount($conn) {
        $users_amount = false;
        $users_amount = get_users_amount($conn);
        if ($users_amount === false) {
            http_response_code(500);
            return json_encode([
                'success' => false,
                'message' => 'Ошибка при получении количества пользователей!'
            ], JSON_UNESCAPED_UNICODE);
        } 
        http_response_code(200);
        return json_encode([
            'success' => true,
            'data' => $users_amount
        ], JSON_UNESCAPED_UNICODE);
    }
    public static function updatePassword($conn, $userId, $password)
    {   
        $userId = IdValidator::validateId($userId);
        $password = UserValidator::validatePassword($password);
        if (!$userId || !$password) {
            http_response_code(422);
            return json_encode([
                'success' => false,
                'message' => 'Заполните поля правильно!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (update_password($conn, $userId, $password)) {
            http_response_code(200);
            return json_encode([
                'success' => true,
            ], JSON_UNESCAPED_UNICODE);
        } 
        http_response_code(404);
        return json_encode([
            'success' => false,
            'message' => 'Пользователя в бд нету!'
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function updateImage($conn, $userId, $image)
    {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'message' => 'Неправильный ID!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (update_image($conn, $userId, $image)) {
            http_response_code(200);
            return json_encode([
                'success' => true
            ], JSON_UNESCAPED_UNICODE);
        }

        http_response_code(404);
        return json_encode([
            'success' => false,
            'message' => 'Пользователь не найден!'
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function updateLogin($conn, $userId, $login)
    {
        $userId = IdValidator::validateId($userId);
        $login = UserValidator::validateLogin($login);
        if (!$userId || !$login) {
            http_response_code(422);
            return json_encode([
                'success' => false,
                'message' => 'Заполните поля правильно!'
            ], JSON_UNESCAPED_UNICODE);
        }
        $sameLogin = get_user_by_login($conn, $login);

        if ($sameLogin) {
            http_response_code(409);
            return json_encode([
                'success' => false,
                'message' => 'Пользователь с таким логином уже существует!'
            ], JSON_UNESCAPED_UNICODE);
        }

        $result = update_login($conn, $userId, $login);

        if ($result === true) {
            http_response_code(200);
            return json_encode([
                'success' => true
            ], JSON_UNESCAPED_UNICODE);
        }

        http_response_code(404);
        return json_encode([
            'success' => false,
            'message' => 'Пользователь не найден!'
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function updateName($conn, $userId, $name)
    {
        $userId = IdValidator::validateId($userId);
        $name = UserValidator::validateName($name);
        if (!$userId || !$name) {
            http_response_code(422);
            return json_encode([
                'success' => false,
                'message' => 'Заполните поля правильно!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (update_name($conn, $userId, $name)) {
            http_response_code(200);
            return json_encode([
                'success' => true,
            ], JSON_UNESCAPED_UNICODE);
        }

        http_response_code(404);
        return json_encode([
            'success' => false,
            'message' => 'Пользователь не найден!'
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function delete($conn, $userId)
    {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            http_response_code(400);
            return json_encode([
                'success' => false,
                'message' => 'Неправильный ID!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (delete_user($conn, $userId)) {
            http_response_code(200);
            return json_encode([
                'success' => true,
                'message' => 'Пользователь успешно удалён!'
            ], JSON_UNESCAPED_UNICODE);
        }

        http_response_code(404);
        return json_encode([
            'success' => false,
            'message' => 'Пользователь не найден!'
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function register($conn, $login, $name, $password)
    {
        $login = UserValidator::validateLogin($login);
        $name = UserValidator::validateName($name);
        $password = UserValidator::validatePassword($password);

        if (!$login || !$name || !$password) {
            http_response_code(422);
            return json_encode([
                'success' => false,
                'message' => 'Заполните все поля правильно!'
            ], JSON_UNESCAPED_UNICODE);
        }
        $response = register_user($conn, $login, $name, $password);

        if ($response === 'Пользователь с таким логином уже существует.') {
            http_response_code(409);
            return json_encode([
                'success' => false,
                'message' => 'Пользователь с таким логином уже существует!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (!$response) {
            http_response_code(500);
            return json_encode([
                'success' => false,
                'message' => 'Ошибка регистрации!'
            ], JSON_UNESCAPED_UNICODE);
            
        }
        http_response_code(201);
        return json_encode([
            'success' => true,
            'message' => 'Пользователь успешно зарегистрирован!'
        ], JSON_UNESCAPED_UNICODE);
    }


    public static function login($conn, $login, $password)
    {
        $login = UserValidator::validateLogin($login);
        $password = UserValidator::validatePassword($password);

        if (!$login || !$password) {
            http_response_code(422);
            return json_encode([
                'success' => false,
                'message' => 'Некорректный логин или пароль!'
            ], JSON_UNESCAPED_UNICODE);
        }

        $user = get_user_by_login($conn, $login);

        if (!$user) {
            http_response_code(401);
            return json_encode([
                'success' => false,
                'message' => 'Неверный логин или пароль!'
            ], JSON_UNESCAPED_UNICODE);
        }

        if (!password_verify($password, $user['password'])) {
            http_response_code(401);
            return json_encode([
                'success' => false,
                'message' => 'Неверный логин или пароль!'
            ], JSON_UNESCAPED_UNICODE);
        }

        http_response_code(200);
        return json_encode([
            'success' => true,
            'data' => $user
        ], JSON_UNESCAPED_UNICODE);
    }

}