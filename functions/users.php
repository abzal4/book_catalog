<?php
function get_users ($conn) {
    $sql = "select * from users";
    $result = mysqli_query($conn, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function get_user_by_Id ($conn, $userId) {
    $sql = "select * from users where id = $userId";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_user_by_login ($conn, $login) {
    $sql = "select * from users where login = '$login'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_users_amount ($conn) {
    $sql = "select count(*) as users_amount from users";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
function update_password($conn, $userId, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "update users set password = '$hash' where id = $userId";
    return mysqli_query($conn, $sql);
}

function update_image($conn, $userId, $image) {
    $sql = "update users set avatar = '$image' where id = $userId";
    return mysqli_query($conn, $sql);
}

function update_login($conn, $userId, $login) {
    $sql = "update users set login = '$login' where id = $userId";
    return mysqli_query($conn, $sql);
}

function update_name($conn, $userId, $name) {
    $sql = "update users set name = '$name' where id = $userId";
    return mysqli_query($conn, $sql);
}

function delete_user($conn, $userId) {
    $sql = "delete from users where id = '$userId'";
    return mysqli_query($conn, $sql);
}

function Register_user($conn, $login, $name, $password) {
    $sql = "select id from users where login = '$login'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        return "Пользователь с таким логином уже существует." ;
    } 
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql_insert = "insert into users (name, login, password) values ('$name', '$login', '$hash')";
    return mysqli_query($conn, $sql_insert);
}
