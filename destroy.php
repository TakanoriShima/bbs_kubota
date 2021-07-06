<?php
    // コントローラ(C)
    require_once 'models/User.php';
    session_start();
    
    // var_dump($_POST);
    // 削除するユーザーのidを取得
    $id = $_POST['id'];
    
    // 削除するユーザーのインスタンスを取得
    $user = User::find($id);
    
    // そのユーザーを削除
    $user->destroy();
    
    // メッセージをセッションに保存
    $_SESSION['flash_message'] = $user->name . 'さんを削除しました';
    
    // リダイレクト
    header('Location: index.php');
    exit;