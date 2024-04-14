<?php
session_start();
require('../library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: ../join/login.php');
  exit();
}

$db = dbconnect();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo h($name); ?></title>
  <link rel="stylesheet" href="../index_style.css">
</head>
<body>
  <header>
    <p><?php echo h($name); ?>さんのノート</p>
    <a href="../logout.php"><button class="header">ログアウト</button></a>
  </header>
  <div class="menu">
    <a href="new_memo.php"><button>新規追加</button></a>
    <form action="検索結果を処理するページのURL" method="get">
      <input type="text" name="search" placeholder="検索...">
      <button type="submit">検索</button>
    </form>
  </div>

  <hr>

  <div class="list">
    <h2>メモ一覧</h2>
    <?php
    $stmt = $db->prepare('select id, users_id, title, memo, created from memos where users_id=? order by id desc');
    if (!$stmt) {
      die($db->error);
    }
    $stmt->bind_param('i', $id);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }

    $stmt->bind_result($id, $users_id, $title, $memo, $created);
    while ($stmt->fetch()):
    ?>
      <ul>
        <div class="memo_title">
          <a href="edit_memo.php?id=<?php echo h($id); ?>"><li><?php echo h($title); ?></li></a>
          <p><?php echo h($created); ?></p>
        </div>
      </ul>
    <?php endwhile; ?>
  </div>
</body>
</html>