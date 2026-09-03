<?php
require_once __DIR__ .'/../includes/db.php';
require_once __DIR__ ."/../controllers/BookController.php";
require_once __DIR__ ."/../controllers/GenreController.php";
require_once __DIR__ ."/../controllers/UserController.php";
require_once __DIR__ ."/../controllers/OrderController.php";
require_once __DIR__ . '/../includes/auth.php';

require_admin();

$action = $_POST['action'] ?? $_GET['action'] ?? " ";
$bookId = $_POST['bookId'] ?? null;

// $users = UserController::getAll($conn);
// $users_amount = UserController::getAmount($conn);
// $genres = GenreController::getAll($conn);
// $genresWithAmount = GenreController::getAllWithAmount($conn);
// $genre_amount = GenreController::getAmount($conn);
// $books_amount = BookController::getAmount($conn);

if ($action === "getBooks") {
    $genre = $_GET['genre'] ?? "Все";
    $search_text = isset($_GET["search_book"]) ? trim($_GET["search_book"]) : "" ;
    $page = $_GET["page"];
    $limit = $_GET["limit"];
    $offset = ($page - 1) * $limit;
    $order_by = $_GET["order_by"];
    $books = BookController::showMany($conn, $genre, $search_text, $limit, $offset, $order_by);
    if (mysqli_num_rows($books) == 0) {
        echo "<b>Нет результатов</b>";
    } else {
        while ($book = mysqli_fetch_assoc($books)) {
            echo "<li> {$book["title"]} ({$book["id"]}) - {$book["genre"]} - {$book["author_name"]} <button onclick=\"window.location.href='../book_edit.php?id={$book['id']}'\" class='editBook'>Изменить</button> <button id={$book["id"]} class='deleteBook'>Удалить</button></li>";
        }
    }
    exit;
}

if ($action === 'getAllOrders') {
    $result = OrderController::getAllOrders($conn);
    if (!$result['success']) {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
        exit;
    }
    echo json_encode($result);
    exit;
}

if ($action == "bookDelete") {
    echo BookController::delete($conn, $bookId );
    exit;
}

if ($action == "genreDelete") {
    if (isset($_POST['genre'])) {
        $genre = $_POST['genre'];
    } else {
        echo "no";
        exit;
    }
    echo GenreController::delete($conn, $genre );
    exit;
}

if ($action == "userDelete") {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);
    echo UserController::delete($conn, $userId );
    exit;
}


if ($action == "editLogin") {
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    echo UserController::updateLogin($conn, $userId, $login);
    exit;
}

if ($action == "editName") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    echo UserController::updateName($conn, $userId, $name);
    exit;
}


if ($action == "editImage") {

    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    echo UserController::updateImage($conn, $userId, $image);
    exit;
}


if ($action == "editPassword") {

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    echo UserController::updatePassword($conn, $userId, $password);
    exit;
}

if ($action == "editStatus") {
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['newStatus']);
    $result = OrderController::updateStatus($conn, $orderId, $newStatus);
    echo json_encode($result);
    exit;
}

if ($action == "register") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    echo UserController::register($conn, $login, $name, $password);
    exit;
}


?>

