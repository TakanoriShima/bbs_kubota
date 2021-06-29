<?php

    // ログインフィルターを読みこみ
    require_once 'login_filter.php';
    // (C)
    require_once 'User.php';
    session_start();
    $login_user = $_SESSION['login_user'];
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    // ビューの表示
    include_once 'top_view.php';
    
    