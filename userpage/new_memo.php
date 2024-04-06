<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規メモ作成</title>
  <link rel="stylesheet" href="memo_style.css">
</head>
<body>
  <form action="メモを保存する処理のURL" method="post" class="full-page-form">
    <input type="text" id="title" name="title" placeholder="タイトルを入力してください" autofocus>
    <textarea id="memo" name="memo" placeholder="メモの内容を入力してください"></textarea>
    <div class="button-container">
      <a href="index.php" class="back-button">戻る</a>
      <button type="submit">保存</button>
    </div>
  </form>
</body>
</html>