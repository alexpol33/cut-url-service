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

    return db_query("SELECT * FROM users WHERE login = '$login'")->fetch();
}

function add_user($login, $pass){
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    return db_exec("INSERT INTO `users` (`id`, `login`, `pass`) VALUES (NULL, '$login', '$pass')");
}

function register_user($data){
    if (empty($data) || !isset($data['login']) || empty($data['login']) || empty($data['pass']) || empty($data['pass2'])) return false;

    $user = get_user_info($data['login']);

    if(!empty($user)){
        $_SESSION['error'] = "Пользователь " . $data['login'] . " уже существует";
        header('Location: register.php');
        die();
    }

    if($data['pass'] !== $data['pass2']){
        $_SESSION['error'] = "Пароли не совпадают";
        header('Location: register.php');
        die();
    }

    if(add_user($data['login'], $data['pass'])){
        $_SESSION['success'] = "Регистрация прошла успешно";
        header('Location: login.php');
        die();
    }


    return true;
}

function login($data){
    if (empty($data) || !isset($data['login']) || empty($data['login']) || !isset($data['pass']) ||empty($data['pass'])) {
        $_SESSION['error'] = "Логин или пароль не могут быть пустыми";
        header('Location: login.php');
        die();
    }

    $user = get_user_info($data['login']);

    if(empty($user)){
        $_SESSION['error'] = "Логин или пароль неверен";
        header('Location: login.php');
        die();
    }

    if(password_verify($data['pass'], $user['pass'])){
        $_SESSION['user_id'] = $user['id'];
        header('Location: profile.php');
        die();
    }else{
        $_SESSION['error'] = "Логин или пароль неверен";
        header('Location: login.php');
        die();
    }


}

function get_user_links($id){
    if(isset($id) && !empty($id)){
       return db_query("SELECT * FROM `links` WHERE user_id = '$id'")->fetchAll();
    }
}

function random_link($length = 8){
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}

function register_link($user_id, $data){
    $long_link = $data['link'];
    $short_link = random_link();
    db_exec("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES (NULL, '$user_id', '$long_link', '$short_link', '0')");
    header("Location: " . get_url('profile.php'));
}