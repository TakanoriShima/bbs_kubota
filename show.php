<?php
    // (C)
    require_once 'login_filter.php';
    require_once 'models/User.php';
    require_once 'models/Post.php';
    require_once 'models/Favorite.php';
    session_start();
    // var_dump($_GET);
    $id = $_GET['id'];
    // print $id;
    // 投稿番号から1つの投稿をDBから抜き出す
    $post = Post::find($id);
    // その投稿に紐づいたコメント一覧を取得
    $comments = $post->comments();
    // var_dump($comments);
    
    // // var_dump($post);
    $login_user = $_SESSION['login_user'];
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    $flag = Favorite::find($login_user->id, $post->id);
    // var_dump($flag);
    // この投稿にいいねした人の一覧を取得
    $favorite_users = $post->favorites();
    // var_dump($favorite_users);
    
    // var_dump($login_user);
    // viewの表示
    include_once 'views/show_view.php';