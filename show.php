<?php
    // (C)
    require_once 'User.php';
    // var_dump($_GET);
    $id = $_GET['id'];
    // print $id;
    // ユーザー番号から1人のユーザーをDBから抜き出す
    $user = User::find($id);
    var_dump($user);