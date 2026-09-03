<?php 
require_once __DIR__ .'/includes/db.php';
require_once __DIR__ ."/controllers/UserController.php";
require_once __DIR__ . '/ajax/edit_profile.php';
include "includes/session.php";

$response = UserController::getById($conn, $_SESSION['userId']);
$data = json_decode($response, true);

if (!$data['success']) {
    http_response_code(404);
    exit($data['message'] ?? 'Пользователь не найден');
}
$user = $data['data']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php include "includes/navigation.php" ?>
    <div class="profile__container">
        <?php include "views/profile/show.php"; ?>
    </div>
    <script>
        let login_change = 0;
        $("#changeLogin").click(async function () {
            if (login_change == 0) {
                let currentLogin = $("#loginText").text();
                $("#loginText").replaceWith(`<input type="text" id="new_login" value="${currentLogin}" required>`);
                $(this).text("Сохранить");
                login_change = 1;
            } else {
                let login = $("#new_login").val();
                try {
                    const formData = new FormData();
                    formData.append("action", "editLogin");
                    formData.append("login", login);
                    const response = await fetch('/../ajax/edit_profile.php', {
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
                    $("#new_login").replaceWith(`<span id="loginText">${login}</span>`);
                    $("#changeLogin").text("Изменить");
                    login_change = 0;
                    alert("Логин изменён");
                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Ошибка соединения с сервером');
                }
            }
        });

        let name_change = 0;
        $("#changeName").click(async function () {
            if (name_change == 0) {
                let currentName = $("#nameText").text();
                $("#nameText").replaceWith(`<input type="text" id="new_name" value="${currentName}" required>`);
                $(this).text("Сохранить");
                name_change = 1;
            } else {
                let name = $("#new_name").val();
                try {
                    const formData = new FormData();
                    formData.append("action", "editName");
                    formData.append("name", name);
                    const response = await fetch('/../ajax/edit_profile.php', {
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
                    $("#new_name").replaceWith(`<span id="nameText">${name}</span>`);
                    $("#changeName").text("Изменить");
                    name_change = 0;
                    alert("Имя изменено");
                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Ошибка соединения с сервером');
                }
            }
        });

        let image_change = 0;
        $("#changeImage").click(async function () {
            if (image_change == 0) {
                let currentImage = $("#imageText").text();
                $("#imageText").replaceWith(`<input type="text" id="new_image" value="${currentImage}" required>`);
                $(this).text("Сохранить");
                image_change = 1;
            } else {
                let image = $("#new_image").val();
                if (image == "") {
                    alert("Заполните поле");
                    return;
                }
                try {
                    const formData = new FormData();
                    formData.append("action", "editImage");
                    formData.append("image", image);
                    const response = await fetch('/../ajax/edit_profile.php', {
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
                    $("#new_image").replaceWith(`<span id="imageText">${image}</span>`);
                    $("#changeImage").text("Изменить");
                    image_change = 0;
                    alert("Изображение изменено");
                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Ошибка соединения с сервером');
                }
            }
        });

        let password_change = 0;
        $("#changePassword").click(async function () {
            if (password_change == 0) {
                $("#passwordText").replaceWith(`<input type="password" id="new_password" value="" required>`);
                $(this).text("Сохранить");
                password_change = 1;
            } else {
                let password = $("#new_password").val();
                if (password == "") {
                    alert("Заполните поле");
                    return;
                }
                try {
                    const formData = new FormData();
                    formData.append("action", "editPassword");
                    formData.append("password", password);
                    const response = await fetch('/../ajax/edit_profile.php', {
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
                    $("#new_password").replaceWith(`<span id="passwordText">********</span>`);
                    $("#changePassword").text("Изменить");
                    password_change = 0;
                    alert("Пароль изменен");
                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Ошибка соединения с сервером');
                }
            }
        });
    </script>
</body>