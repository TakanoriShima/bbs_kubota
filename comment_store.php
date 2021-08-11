<?php
    require_once 'models/User.php';
    require_once 'models/Comment.php';
    session_start();
    // var_dump($_POST);
    // 投稿番号取得
    $post_id = $_POST['post_id'];
    // コメント内容取得
    $content = $_POST['content'];
    // ログインユーザの取得
    $login_user = $_SESSION['login_user'];
    
    // var_dump($login_user);
    
    // 新しいコメントインスタンス生成
    $comment = new Comment($login_user->id, $post_id, $content);
    // 入力チェック
    $errors = $comment->validate();
    
    // var_dump($errors);
    // 入力エラーが1つもなければ
    if(count($errors) === 0){
        //データベースにコメント保存
        $flash_message = $comment->save();
        $_SESSION['flash_message'] = $flash_message;
        
        header('Location: show.php?id=' . $post_id);
        exit;
        
    }else{
        $_SESSION['errors'] = $errors;
        header('Location: show.php?id=' . $post_id);
        exit;
    }
    
    // var_dump($comment);