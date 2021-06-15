<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ユーザー一覧</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--ビュー(V)-->
        <h1>ユーザー一覧</h1>
        <?php if($flash_message !== null): ?>
        <p class="message"><?= $flash_message ?></p>
        <?php endif; ?>
        
        <?php if(count($users) === 0): ?>
        <p>ユーザーはまだいません</p>
        <?php else: ?>
        <p>ユーザー人数: <?= count($users) ?>人</p>
        <?php foreach($users as $user): ?>
        <ul>
            <li><a href="show.php?id=<?= $user->id ?>"><?= $user->id ?></a></li>
            <li><?= $user->name ?></li>
            <li><?= $user->age . '歳' ?></li>
            <li><?= $user->created_at ?></li>
        </ul>
        <?php endforeach; ?>
        <?php endif; ?>
        
        <p><a href="create.php">新規ユーザー登録</a></p>
        <!--<p><a href="destroy.php">全ユーザー削除</a></p>-->
    </body>
</html>