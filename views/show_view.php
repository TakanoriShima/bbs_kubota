<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?= $user->name ?>さんの詳細</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--ビュー(V)-->
        <h1><?= $user->name ?>さんの詳細</h1>
        <?php if($flash_message !== null): ?>
        <p class="message"><?= $flash_message ?></p>
        <?php endif; ?>
        
        <ul>
            <li><?= $user->id ?></li>
            <li><?= $user->name ?></li>
            <li><?= $user->age . '歳' ?></li>
            <li><?= $user->created_at ?></li>
        </ul>

        <p><a href="index.php">ユーザー一覧へ</a></p>
        <p><a href="edit.php?id=<?= $user->id ?>">編集</a></p>
        <form action="destroy.php" method="POST">
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <button type="submit">削除</button>
        </form>
    </body>
</html>