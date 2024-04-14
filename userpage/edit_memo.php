<?php
session_start();
require('../library.php');
$db = dbconnect();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}

// 入力内容の表示
$memo_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db->prepare('select id, title, memo, created from memos where id=?');
if(!$stmt) {
  die($db->error);
}
$stmt->bind_param('i', $memo_id);
$stmt->execute();
$stmt->bind_result($memo_id, $title, $memo, $created);
$result = $stmt->fetch();
$stmt->close();
if (!$result) {
  die($db->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['action'] === 'update') {
    // POSTリクエストからデータを取得
    $memo_id = filter_input(INPUT_POST, 'memo_id', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_SPECIAL_CHARS);
  
    // データベースを更新
    $stmt = $db->prepare('update memos set title=?, memo=? where id=?');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bind_param('ssi', $title, $memo, $memo_id);
    $stmt->execute();
  } elseif ($_POST['action'] === 'delete') {

  }
  
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo h($title) ?></title>
  <link rel="stylesheet" href="memo_style.css">
</head>
<body>
  <form action="" method="post" class="full-page-form">
    <input type="hidden" name="memo_id" value="<?php echo h($memo_id); ?>">
    <input type="text" id="title" name="title" value="<?php echo h($title); ?>" autofocus>
    <textarea id="memo" name="memo"><?php echo h($memo); ?></textarea>
    <div class="button-container">
      <a href="index.php" class="back-button">戻る</a>
      <button type="submit" name="action" value=
      "delete" class="delete">削除</button>
      <button type="submit" name="action" value=
      "update">更新</button>
    </div>
  </form>
</body>
</html>