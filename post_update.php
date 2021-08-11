<?php
    // (C)
    // var_dump($_POST);
    // var_dump($_FILES);

    require_once 'models/User.php';
    require_once 'models/Post.php';
    session_start();
    
    // 入力した情報を取得
    $id = $_POST['id'];
    $post = Post::find($id);
    // var_dump($post);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    
    $login_user = $_SESSION['login_user'];
    
    $post->title = $title;
    $post->content = $content;
    
    // ファイルが選択されていなければ
    if($_FILES['image']['size'] === 0){
        $image = $post->image;
    }
    
    $post->image = $image;
    
    // var_dump($post);
    
    $errors = $post->validate();
    // var_dump($errors);
    
    // 入力エラーが一つもなければ
    if(count($errors) === 0){
        // 画像が選択されていれば
        if($_FILES['image']['size'] !== 0){
            $image = mt_rand(100, 10000) . $image;
            $post->image = $image;
        }
        
        // データベースを更新
        $flash_message = $post->save();
        
        // 画像のフルパスを設定
        $file = 'upload/' . $image;
    
        // uploadディレクトリにファイル保存
        move_uploaded_file($_FILES['image']['tmp_name'], $file);
        
        $_SESSION['flash_message'] = $flash_message;
        // リダイレクト
        header('Location: show.php?id=' . $id);
        exit;
        
    }else{ // 入力エラーが一つでもあれば
        $_SESSION['errors'] = $errors;
        // リダイレクト
        header('Location: post_edit.php?id=' . $id);
        exit;
    }
    