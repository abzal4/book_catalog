<?php

require_once __DIR__ .'/../functions/favorites.php';
require_once __DIR__ .'/../validators/IdValidator.php';

class FavoriteController {
    public static function get($conn, $userId)
    {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            exit('Неккоректный ID пользователя');
        }
        $user_books = get_user_favorite_books($conn, $userId);
        return $user_books;
    }

    public static function getId($conn, $userId)
    {
        $userId = IdValidator::validateId($userId);
        if (!$userId) {
            exit('Неккоректный ID пользователя');
        }
        $ids = get_user_favorite_books_ids($conn, $userId);
        return $ids;
    }

    public static function add($conn, $userId, $bookId)
    {
        $bookId = IdValidator::validateId($bookId);

        if (!$bookId) {
            return "Некорректный ID книги";
        }

        if (is_favorite($conn, $userId, $bookId)) {
            return is_favorite($conn, $userId, $bookId);
            return "Книга уже в избранном";
        }

        if (add_to_favorites($conn, $userId, $bookId)) {
            return "ok";
        }

        return "Ошибка добавления";
    }


    public static function remove($conn, $userId, $bookId)
    {
        $bookId = IdValidator::validateId($bookId);

        if (!$bookId) {
            return "Некорректный ID книги";
        }

        if (remove_from_favorites($conn, $userId, $bookId)) {
            return "ok";
        }

        return "Ошибка удаления";
    }
}