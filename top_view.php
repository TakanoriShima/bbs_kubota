<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>My Top</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--ビュー(V)-->
        <h1>会員制写真投稿サイト</h1>
        <?php if($flash_message !== null): ?>
        <p class="message"><?= $flash_message ?></p>
        <?php endif; ?>
        
        <h2><?= $login_user->name ?>さん、ようこそ！</h2>
        
        <p><a href="post_create.php">新規写真投稿</a></p>
        <p><a href="logout.php">ログアウト</a></p>
        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>