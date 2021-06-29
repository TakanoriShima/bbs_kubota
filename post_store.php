<?php
    // (C)
    // var_dump($_POST);
    // var_dump($_FILES);

    require_once 'User.php';
    require_once 'Post.php';
    session_start();
    
    // 入力した情報を取得
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    
    $login_user = $_SESSION['login_user'];
    
    // 新しい投稿インスタンスを作成
    $post = new Post($login_user->id, $title, $content, $image);
    var_dump($post);
    // データベースに保存
    // $post->save();