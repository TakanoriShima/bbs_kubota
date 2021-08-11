<?php
    // (C)
    require_once 'models/User.php';
    $id = $_GET['id'];
    // print $id;
    // ユーザーidからデータを取得
    $user = User::find($id);
    // var_dump($user);
    // そのユーザーが投稿した一覧を取得
    // $posts = $user->posts();
    $posts = array();
    
    include_once 'views/users_show_view.php';