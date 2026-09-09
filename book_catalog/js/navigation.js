<?php
require_once "includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = 0;

if ($_SESSION['role'] == 'admin') {
    $isAdmin = 1;    
}

$sql_user = "select * from users where id = ". $_SESSION['userId'];
$user_result = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($user_result);

$sql_user_books = "select book_id from favorites where user_id = ". $_SESSION['userId'];
$user_books_result = mysqli_query($conn, $sql_user_books);
$user_books = [];
while ($row = mysqli_fetch_assoc($user_books_result)) {
    $user_books[] = $row['book_id'];
}
?>


        <a class="profile" href="profile.php">
            <img src="<?php echo $user['avatar'] ; ?>" alt="profile_image" class="profile_image">
            <p class="profile__name">
                <?php echo $user['name']; ?>
            </p>
        </a>
        <?php if ($isAdmin == 1) { echo '<a href="admin/admin.php">Меню админа</a>';} ?>