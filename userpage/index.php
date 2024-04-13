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
  <title>あなたのメモ</title>
  <link rel="stylesheet" href="../index_style.css">
</head>
<body>
  <header>
    <p><?php echo h($name); ?>さんのノート</p>
    <button class="header">ログアウト</button>
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
    <ul>
      <a href=""><li>memoタイトル</li></a>
      <a href=""><li>memoです</li></a>
      <a href=""><li>memoです</li></a>
    </ul>
  </div>
</body>
</html>