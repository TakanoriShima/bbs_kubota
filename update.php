<?php
    // 外部ファイルの読みこみ
    require_once 'User.php';
    // セッション開始（すべてのファイルが使える情報の共有箱）
    session_start();
    // コントローラ(C)
    // print 'OK';
    // $_POST, $_GET スーパーグローバル変数
    // var_dump($_POST);
    $name = $_POST['name'];
    $age = $_POST['age'];
    $id = $_POST['id'];
    // print $name;
    // print $age;
    
    $user = User::find($id);
    // var_dump($user);
    $user->name = $name;
    $user->age = $age;
    
    // var_dump($user);
    
    // 入力チェック(validation)
    $errors = $user->validate();
    // var_dump($errors);
    
    // 名前も年齢も両方正しく入力されていれば
    if(count($errors) === 0){
        
        // 新しく作られたユーザーのインスタンスをDBに保存
        $flash_message = $user->save();
        
        $_SESSION['flash_message'] = $flash_message;
        
        // // リダイレクト（画面が変わる）
        header('Location: index.php');
        exit;
    }else{ // 入力エラーが1つでもあれば
        // エラー配列をセッションに保存
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: edit.php?id=' . $id);
        exit;
    }
    