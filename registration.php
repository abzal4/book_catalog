<?php
require_once 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth__container">
        <h2 class="auth_title">Регистрация</h2>

        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
        <form method="POST" id="registrationForm">
            <input type="text" name="name" id="name" placeholder="Имя"> <br><br>
            <input type="text" name="login" id="login" placeholder="Логин"> <br><br>
            <input type="password" name="password" id="password" placeholder="Пароль"> <br><br>
            <button type="submit" name="register">Регистрация</button>
        </form>
        <br>
        <a href="login.php">Уже есть аккаунт?</a>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
const registrationForm = document.getElementById('registrationForm');
registrationForm.addEventListener("submit", async function (event) {
    event.preventDefault(); 
    const formData = new FormData(registrationForm); 
    formData.append("action", "register");
    try {
            const response = await fetch('/ajax/auth_back.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            if (!response.ok || !data.success) {
                alert(data.message);
                return;
            }
            window.location.href = 'login.php?success=1';

        } catch (error) {
            console.error(error);
            alert('Ошибка соединения с сервером');
        }
});
</script>