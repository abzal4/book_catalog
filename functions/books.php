<?php
function get_book_by_id($conn, $bookId) {
    $sql_books = "select * from imported_books where id={$bookId}";
    $result = mysqli_query($conn, $sql_books); 
    $book = mysqli_fetch_assoc($result);
    return $book;
}

function get_books_by_ids($conn, $bookIds) {
    $ids_string = implode(',', $bookIds);
    $sql_books = "select * from imported_books where id in ($ids_string)";
    $result = mysqli_query($conn, $sql_books);
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    return $books;
}

function get_books_by_genre($conn, $genre) {
    $sql_books = "select * from imported_books where genre = $genre";
    $result = mysqli_query($conn, $sql_books);
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    return $books;
}

function get_books($conn, $genre, $search_text, $limit, $offset, $order_by) {
    $sql_books = "select * from imported_books";
    $conditions = [];

    if ($genre !== "Все") {
        $conditions[] = "genre like '%" . $genre . "%'";
    }
    if ($search_text !== "") {
        $conditions[] = "(title like '%" . $search_text . "%' or author_name like '%" . $search_text . "%')";
    }
    if (!empty($conditions)) {
        $sql_books = $sql_books . " where " . implode(" and ", $conditions);
    }

    $sql_books .= " order by title " . $order_by;
    $sql_books .= " limit " . $limit;
    $sql_books .= " offset " . $offset;

    // echo "<br><div class='query__text'>Query:<br>";
    // echo $sql_books . "<br></div><br>";

    $result = mysqli_query($conn, $sql_books); 
    return $result;
}

function get_books_amount ($conn) {
    $sql = "select count(*) as books_amount from imported_books";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function create_book($conn, $title, $author, $genre, $year) {
    $sql = "insert into imported_books (title, author_name, genre, first_publish_year) values ('$title', '$author', '$genre', '$year')";
    return mysqli_query($conn, $sql);
}

function update_book($conn, $id, $title, $author, $genre, $year) {
    $sql = "update imported_books set title = '$title', author_name = '$author', genre = '$genre', first_publish_year = '$year' where id = $id";
    return mysqli_query($conn, $sql);
}

function delete_book($conn, $id) {
    $sql = "delete from imported_books where id = '$id'";
    return mysqli_query($conn, $sql);
}

function import_open_library_books($conn, $genre) {
        $sql_books_by_genre_in_db = "select count(*) from imported_books where genre ='$genre'";
        
        $result = mysqli_query($conn, $sql_books_by_genre_in_db);
        $books_by_genre_in_db = mysqli_fetch_assoc($result);
        $amount = $books_by_genre_in_db["count(*)"] + 1;
        
        $url = "https://openlibrary.org/search.json?subject=$genre&limit=100&offset=$amount";
        $json = file_get_contents($url);
        $data = json_decode($json, true);        
        
        $imported = 0;
        $imported_books = [];
        foreach ($data["docs"] as $book) {
            $title = mysqli_real_escape_string($conn, $book["title"]);
            $subtitle = mysqli_real_escape_string($conn, $book["subtitle"] ?? "");
            $work_key = mysqli_real_escape_string($conn, $book["key"]);
            $author_name = mysqli_real_escape_string($conn, $book["author_name"][0] ?? "");
            $genre = mysqli_real_escape_string($conn, $genre);
            $cover_i = isset($book["cover_i"]) ? $book["cover_i"] : "NULL";
            $first_publish_year = isset($book["first_publish_year"]) ? $book["first_publish_year"] : "NULL";

            $sql_import = "insert into imported_books 
                            (title, subtitle, work_key, author_name, genre, cover_i, first_publish_year)
                            VALUES ('$title', '$subtitle', '$work_key', '$author_name', '$genre', $cover_i, $first_publish_year )";
            $sql_check = "select count(*) from imported_books where work_key='$work_key'";
            $result = mysqli_query($conn, $sql_check);
            $amount = mysqli_fetch_assoc($result);
            $amount = $amount["count(*)"];
            if ($amount > 0) {
                continue;
            }

            $result = mysqli_query($conn, $sql_import);

            if (!$result) {
                die(mysqli_error($conn));
            }
            $imported++;
            $imported_books[] = [
                "title" => $book["title"],
                "author" => $book["author_name"][0] ?? "Неизвестен"
            ];
        }
        return [
            "url" => $url,
            "imported" => $imported,
            "genre" => $genre,
            "books" => $imported_books
        ];
}

function get_quantity_in_stock($conn, $bookId) {
    $sql = "select quantity from imported_books where id = $bookId";
    $result = mysqli_query($conn, $sql);
    // $row = mysqli_fetch_assoc($result);
    // return (int)$row['quantity'];
    if (!$result) {
        error_log(mysqli_error($conn));
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        return 0;
    }
    return (int)$row['quantity'];
}

function update_stock($conn, $bookId, $difference) {
    $sql = "update imported_books set quantity = quantity + $difference where id = $bookId";
    return mysqli_query($conn, $sql);
}