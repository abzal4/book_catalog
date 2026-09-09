<?php
    include "db.php";

    function get_books($conn, $hasfilter, $hasSearch) {
        $sql_books = "select * from books";
        global $genre;
        global $min_price;
        global $max_price;
        global $search_text;
        $filterCount = 0;
        if ($hasfilter) {
            $sql_books = $sql_books . " where";
            
            if ($genre != "Все") {
                $sql_books = $sql_books . " genre like '%" . $genre . "%'";
                $filterCount++;
            }
        
            if ($_GET["min_price"] !== ""  || $_GET["max_price"] !== "") {
                if ($filterCount>0){
                    $sql_books = $sql_books . " and";
                } 
                $sql_books = $sql_books . " price >= " . $min_price . " and price <= " . $max_price;
                $filterCount++;
            }
        }


        if ($hasSearch) {
            if ($filterCount==0) {
                $sql_books = $sql_books . " where";
            } else {
                $sql_books = $sql_books . " and";
            }
            $sql_books = $sql_books . " (title like '%" . $search_text . "%'"  . " OR author like '%" . $search_text . "%')";
          
        }
        echo "<br><div class='query__text'>Query:<br>";
        echo $sql_books . "<br> </div><br>";
        $result = mysqli_query($conn, $sql_books);
        return $result;
    }

    if (isset($_GET['genre'])) {
        $genre = $_GET['genre'] ?? "Все";
        $min_price = $_GET['min_price'] !== "" ? $_GET['min_price'] : 0;
        $max_price = $_GET['max_price'] !== "" ? $_GET['max_price'] : 100000;
        $search_text = isset($_GET["search_book"]) ? trim($_GET["search_book"]) : "" ;
        
        $hasfilter = $_GET['genre'] !== "Все" || $_GET['min_price'] !== "" || $_GET['max_price'] !== "";
        $hassearch = $_GET['search_book'] !== "";

        $books = get_books ($conn, $hasfilter, $hassearch);
        
        echo "<br><br><b style='font-size: 20px;'>Результаты поиска</b>";

        if ($genre != "Все") {
            echo " | Жанр: $genre";
        }
        if ($min_price != "") {
            echo " | Цена от: $min_price тг";
        }
        if ($max_price != "") {
            echo " | Цена до: $max_price тг";
        }
        echo ":<br><br>";

        if (mysqli_num_rows($books) == 0) {
            echo "<b>Нет результатов</b>";
        } else {
            while ($book = mysqli_fetch_assoc($books)) {
                echo $book["title"] . " (" . $book["year"] . ") - " 
                    . $book["genre"] . " - " . $book["author"] . " - " 
                    . $book["price"] . "тг <br>";
                echo '<a href="book.php?id=' . $book["id"] . '">Подробнее</a> <br><br>';
            }
        }
        exit;
    }
?>