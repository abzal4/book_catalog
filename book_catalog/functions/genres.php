<?php 

function get_genres ($conn) {
    $sql = "select distinct genre from imported_books";
    return mysqli_query($conn, $sql);
}

function get_genres_amount ($conn) {
    $sql = "select count(distinct genre) as genre_amount from imported_books";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function delete_genre($conn, $genre) {
    $sql = "delete from imported_books where genre = '$genre'";
    return mysqli_query($conn, $sql);
}

function get_genres_with_amount($conn)
{
    $sql = "
        select genre, COUNT(*) AS amount
        FROM imported_books
        GROUP BY genre;
    ";
    $result = mysqli_query($conn, $sql);
    $genres = [];
    while ($genre = mysqli_fetch_assoc($result)) {
        $genres[] = $genre;
    }
    return $genres;
}