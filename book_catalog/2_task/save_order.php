<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "db.php";
require_once "vendor/autoload.php";

if (!empty($_POST['email']) && !empty($_POST['name'])) {
    $book_title = $_POST['book_title'];
    $book_id = $_POST['book_id'];
    $book_price = $_POST['book_price'];
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_number = $_POST['number'];
    $email = $_POST['email'];

    $file = 'orders.txt';
    $text = "Книга: $book_title ($book_id) - $book_price тг;    " .
            "Имя: $user_name;  email: $user_email;  number: $user_number; \n" ;
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'flynnaba@gmail.com';  
        $mail->Password = 'cmtg uydt hhgd wyca';             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->CharSet = 'UTF-8';

        $mail->setFrom('flynnaba@gmail.com', 'Мой сайт');

        $mail->addAddress($user_email, $user_name);

        $mail->isHTML(true);
        $mail->Subject = 'Завка на покупку книги';
        $mail->Body =   $text;

        $mail->send();

    } catch (Exception $e) {
        echo $mail->ErrorInfo;
    }

    file_put_contents($file, $text, FILE_APPEND);
    $sql = "insert into orders (book_id, user_name, user_email, user_number) values ('$book_id', '$user_name', '$user_email', $user_number);";
    mysqli_query($conn, $sql);

    echo "<p style='color: green;'>Заявка отрпавлена</p><br>";
    echo "<a href='index.php'>Вернуться назад</a>";
} else {
    echo "<p style='color: red;'>Заполните поля</p>";
}

?>