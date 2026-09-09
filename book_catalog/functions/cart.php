<?php

// function get_user_favorite_books($conn, $userId) {
//     $sql_user_books_id = "select book_id from favorites where user_id = {$userId}";
//     $user_books_id_result = mysqli_query($conn, $sql_user_books_id);
//     $user_books_id = [];
//     while ($row = mysqli_fetch_assoc($user_books_id_result)) {
//         $user_books_id[] = $row["book_id"];
//     }
//     if (empty($user_books_id)) {
//         return [];
//     }
//     $ids = implode(',', $user_books_id);
    
//     $sql_user_books = "select * from imported_books where id in ($ids)";
//     $user_books = mysqli_query($conn, $sql_user_books);
//     return $user_books;
// }

// function get_user_favorite_books_ids($conn, $userId) {
//     $sql_user_books_id = "select book_id from favorites where user_id = {$userId}";
//     $user_books_id_result = mysqli_query($conn, $sql_user_books_id);
//     $user_books_id = [];
//     while ($row = mysqli_fetch_assoc($user_books_id_result)) {
//         $user_books_id[] = $row["book_id"];
//     }
//     if (empty($user_books_id)) {
//         return [];
//     }
//     return $user_books_id;
// }

function add_to_favorites($conn, $userId, $bookId)
{   
    $sql = "insert into favorites value ($userId, $bookId)";
    return mysqli_query($conn, $sql);
}

function remove_from_favorites($conn, $userId, $bookId)
{
    $sql = "delete from favorites where user_id = $userId and book_id = $bookId";
    return mysqli_query($conn, $sql);
}

// function is_favorite($conn, $userId, $bookId)
// {
//     $sql = "
//         SELECT EXISTS(
//             SELECT 1
//             FROM favorites
//             WHERE user_id = {$userId}
//               AND book_id = {$bookId}
//         ) AS is_favorite
//     ";
//     $result = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_assoc($result);
//     return (bool)$row['is_favorite'];
// }