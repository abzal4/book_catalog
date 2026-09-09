<?php

require_once __DIR__ .'/../functions/genres.php';

class GenreController {

    public static function getAll($conn) {
        $genres = false;
        $genres = get_genres($conn);
        if ($genres) {
            return $genres;
        } else {
            exit("Пусто");
        }
    }

    public static function getAmount($conn) {
        $genres_amount = false;
        $genres_amount = get_genres_amount($conn);
        if ($genres_amount) {
            return $genres_amount;
        } else {
            exit("Пусто");
        }
    }

    public static function getAllWithAmount($conn)
    {
        $result = false;
        $result = get_genres_with_amount($conn);
        if ($result) {
            return $result;
        } else {
            exit("Пусто");
        }
    }

    public static function delete($conn, $genre) 
        {
            if (delete_genre($conn, $genre)) {
                return "ok";
            }
            return "Ошибка удаления";
        }
}