<?php
    // (C)
    require_once 'models/User.php';
    // var_dump($_GET);
    $id = $_GET['id'];
    // print $id;
    // ユーザー番号から1人のユーザーをDBから抜き出す
    $user = User::find($id);
    // var_dump($user);
    
    // viewの表示
    include_once 'views/show_view.php';