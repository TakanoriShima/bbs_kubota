<?php
    // (C)
    session_start();
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // viewの表示
    include_once 'login_view.php';