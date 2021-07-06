<?php
    // (C)
    require_once 'models/User.php';
    session_start();
    // var_dump($_GET);
    $id = $_GET['id'];
    // print $id;
    // ユーザー番号から1人のユーザーをDBから抜き出す
    $user = User::find($id);
    // var_dump($user);
    
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // viewの表示
    include_once 'views/edit_view.php';