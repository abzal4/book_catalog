<?php

require_once __DIR__ .'/../functions/books.php';
require_once __DIR__ .'/../validators/IdValidator.php';

class BookController {
    public static function showOne($conn, $bookId) 
    {
        $bookId = IdValidator::validateId($bookId);

        if (!$bookId) {
            return [
                'success' => false,
                'message' => 'Некорректный ID книги',
                'data' => null
            ];
        }

        $book = get_book_by_id($conn, $bookId);
    
        if (!$book) {
            exit("Книга не найдена");
        }
        return $book;
    }

    public static function showByGenre($conn, $genre) 
    {
        $books = get_books_by_genre($conn, $genre);
    
        if (!$books) {
            exit("Пусто");
        }
        return $books;
    }

    public static function create($conn, $title, $author, $genre, $year)
    {
        if (create_book($conn, $title, $author, $genre, $year)) {
            return "ok";
        } else {
            exit("Книга не добавлена");
        }
    }

    public static function update($conn, $bookId, $title, $author, $genre, $year)
    {
        if (update_book($conn, $bookId, $title, $author, $genre, $year)) {
            return "ok";
        } else {
            exit("Книга не изменена");
        }
    }

    public static function showMany($conn, $genre, $search_text, $limit, $offset, $order_by)
    {
        $books = get_books($conn, $genre, $search_text, $limit, $offset, $order_by);

        return $books;
    }

    public static function delete($conn, $bookId) 
    {
        $bookId = IdValidator::validateId($bookId);

        if (!$bookId) {
            exit('Неккоректный ID книги');
        }
    
        if (delete_book($conn, $bookId)) {
            return "ok";
        }

        return "Ошибка удаления";
    }
    
    public static function getAmount($conn) 
    {
        $books = get_books_amount($conn);
    
        if (!$books) {
            exit("В БД нету книг");
        }
        return $books;
    }

    public static function getQuantityInStock($conn, $bookId) 
    {
        $bookId = IdValidator::validateId($bookId);
        if (!$bookId) {
            return 0;
        }
        $quantity = get_quantity_in_stock($conn, $bookId);
        return $quantity;
    }

    public static function checkStock($conn, $bookId, $cartQuantity)
    {
        $bookId = IdValidator::validateId($bookId);
        if (!$bookId) {
            return [
                'success' => false,
                'message' => 'Неправильный ID!'
            ];
        }    

        $inStock = get_quantity_in_stock($conn, $bookId);
        if ($inStock <= 0) {
            return [
                'success' => false,
                'message' => 'Нет в наличии.'
            ];
        }

        if ($cartQuantity > $inStock) {
            return [
                'success' => false,
                'message' => 'Недостаточно товара на складе.'
            ];
        }

        return [
            'success' => true,
            'quantity' => $inStock
        ];
    }
    
}