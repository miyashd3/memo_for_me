<?php
session_start();
require ('../library.php');
$db = dbconnect();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: ../join/login.php');
  exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
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
    <form action="search_result.php" method="get">
      <input type="text" name="search" placeholder="検索...">
      <button type="submit">検索</button>
    </form>
  </div>

  <hr>

  <div class="list">
    <h2>メモ一覧</h2>
    <?php 
    if ($id !== null && $search !== ''):
      $sql = "SELECT * FROM memos WHERE (title LIKE ? OR memo LIKE ?) AND users_id = ?";
      $stmt = $db->prepare($sql);
      
      $searchParam = '%' . $search . '%';
      $stmt->bind_param("ssi", $searchParam, $searchParam, $id); 
    
      $stmt->execute();
    
      $result = $stmt->get_result();
    
      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <ul>
      <div class="memo_title">
        <a href="edit_memo.php?id=<?php echo h($row['id']); ?>"><li><?php echo h($row['title']); ?></li></a>
        <p><?php echo h($row['created']); ?></p>
      </div>
    </ul>
    <?php
        endwhile;
      else:
        echo '検索結果が見つかりませんでした。';
      endif;
      $stmt->close();
    else:
      echo '検索クエリが入力されていません、またはログインしていません。';
    endif;
    ?>
  </div>
  