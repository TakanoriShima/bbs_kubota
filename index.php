<?php
    // コントローラ（C）
    // 外部ファイルの読みこみ
    require_once 'User.php';
    // セッション開始
    session_start();

    // セッションからメッセージを抜きだす
    $flash_message = $_SESSION['flash_message'];
    // セッションからメッセージを削除
    $_SESSION['flash_message'] = null;
    
    // HTMLファイル表示
    include_once 'index_view.php';