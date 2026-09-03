<?php
require_once "../includes/session.php";
include "../includes/db.php";
require_once "../controllers/FavoriteController.php";
require_once "../controllers/BookController.php";
require_once '../validators/IdValidator.php';


$userId = $_SESSION['userId'] ?? '';
$action = $_POST['action'] ?? $_GET['action'] ?? "";
$bookId = $_POST['bookId'] ?? null;
$user_books[] = [];
http_response_code(200);

if ($userId) {
    $user_books = FavoriteController::getId($conn, $userId);
}

if ($action === "addToCart") {
    if (!$_SESSION['cart']) {
        $_SESSION['cart']=[];
    }
    
    $currentAmount = $_SESSION['cart'][$bookId] ?? 0;

    $checkStock = BookController::checkStock($conn, $bookId, $currentAmount);

    if (!$checkStock['success']) {
        echo json_encode([
            'success' => false,
            'message' => $checkStock['message'],
            'cart' => $_SESSION['cart']
        ]);
        exit;
    }

    $_SESSION['cart'][$bookId] = $currentAmount + 1;
    echo json_encode([
        'success' => true,
        'cart' => $_SESSION['cart']
    ]);
    exit;
}

if ($action === "removeFromCart") {
    if (!$_SESSION['cart']) {
        $_SESSION['cart']=[];
    }
    $bookId = IdValidator::validateId($bookId);
    if (!$bookId) {
        http_response_code(400);
        echo json_encode([
            'success'=>false,
            'message'=>"Неправильный id",
        ]);
        exit;
    }
    if (isset($_SESSION['cart'][$bookId])) {
        $_SESSION['cart'][$bookId]--;
        if ($_SESSION['cart'][$bookId]==0) {
            unset($_SESSION['cart'][$bookId]);
        }
    }
    echo json_encode([
        'success'=>true,
        'cart' => $_SESSION['cart'],
        ]);
    exit;
}

if ($action === "addToFav") {
    echo FavoriteController::add( $conn, $userId, $bookId );
    exit;
}

if ($action === "delFromFav") {
    echo FavoriteController::remove($conn, $userId, $bookId );
    exit;
}

if ($action === "favoriteBooks") {
    $favorite_books = FavoriteController::get($conn, $userId);
    if (empty($favorite_books)) {
        echo '<p>У вас нет избранных книг.</p>';
        exit;
    } else {
        while ($book = mysqli_fetch_assoc($favorite_books)) {
            if (in_array($book["id"], $user_books)) {
                $book['title'] = $book['title'] . '⭐';
            }
            $books_array[] = $book;
        }
    }
    include "../views/books/book-card.php";
    exit;
}

if ($action == "editBook") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    echo BookController::update($conn, $bookId, $title, $author, $genre, $year );
    exit;
}

if ($action == "createBook") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    echo BookController::create($conn, $title, $author, $genre, $year );
    exit;
}

if ($action === "getBooks") {
    $genre = $_GET['genre'] ?? "Все";
    $search_text = trim($_GET["search_book"]) ?? "" ;
    $page = $_GET["page"] ?? 1;
    $limit = $_GET["limit"] ?? 10;
    $offset = ($page - 1) * $limit;
    $order_by = $_GET["order_by"] ?? "asc";
    $SQLbooks = BookController::showMany($conn, $genre, $search_text, $limit, $offset, $order_by);
    if (mysqli_num_rows($SQLbooks) == 0) {
        echo "<b>Нет результатов</b>";
        exit;
    } else {
        while ($book = mysqli_fetch_assoc($SQLbooks)) {
            if (in_array($book["id"], $user_books)) {
                $book['title'] = $book['title'] . '⭐';
            }
            $books_array[] = $book;
        }
    }
    include "../views/books/book-card.php";
    exit;
}

if ($action === "importBooks") {
    $genre = $_POST['genre'];
    $result = import_open_library_books($conn, $genre);

    echo "<p class='query__text'>";
    echo htmlspecialchars($result["url"]);
    echo "</p><br><br>";

    echo "<b style='font-size: 20px;'>";
    echo "Добавлены книги по жанру - ";
    echo ($result["genre"]);
    echo ": ";
    echo $result["imported"];
    echo "</b><br><br>";
    if (!empty($result["books"])) {
        echo "<div class='imported-books'>";
        foreach ($result["books"] as $book) {
            echo "{$book['title']} - {$book['author']} <br>";
        }

        echo "</div>";

    } else {
        echo "<b>Новых книг не добавлено</b>";
    }
    exit;
}

echo "Неизвестное действие";

?>