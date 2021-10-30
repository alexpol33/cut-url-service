<?php
include_once 'includes/config.php';

function get_url($page = ''){
    return HOST . "/$page";
}

function db(){
    try {
        return new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e){
        die($e->getMessage());
    }
}

function db_query($sql = ''){
    if(empty($sql)) return false;

    return db()->query($sql);
}

function db_exec($sql = ''){
    if(empty($sql)) return false;

    return db()->exec($sql);
}

function get_user_info($login){
    if (empty($login)) return [];

    return db_query("SELECT * FROM users WHERE login = '$login'");
}

function register_user($data){
    if (empty($data) || !isset($data['login']) || empty($data['login']) || empty($data['pass']) || empty($data['pass2'])) return false;

    $user = get_user_info($data['login']);

    if(!empty($user)){
        $_SESSION['error'] = "Пользователь " . $data['login'] . " уже существует";
        header('Location: register.php');
        die();
    }


    return true;
}