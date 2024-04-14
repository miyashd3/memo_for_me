<?php
session_start();
require('../library.php');

$db = dbconnect();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: ../join/login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $stmt = $db->prepare('insert into memos(users_id, title, memo) values(?, ?, ?)');
  if (!$stmt) {
    die($db->error);
  }

  $stmt->bind_param('iss', $id, $title, $memo);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規メモ作成</title>
  <link rel="stylesheet" href="memo_style.css">
</head>
<body>
  <form action="" method="post" class="full-page-form">
    <input type="text" id="title" name="title" placeholder="タイトルを入力してください" autofocus>
    <textarea id="memo" name="memo" placeholder="メモの内容を入力してください"></textarea>
    <div class="button-container">
      <a href="index.php" class="back-button">戻る</a>
      <button type="submit">保存</button>
    </div>
  </form>
</body>
</html>