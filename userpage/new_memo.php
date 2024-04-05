<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規作成</title>
</head>
<body>
<form action="メモを保存する処理のURL" method="post">
    <label for="title">タイトル:</label>
    <input type="text" id="title" name="title" placeholder="タイトルを入力してください">
    
    <label for="memo">内容:</label>
    <textarea id="memo" name="memo" placeholder="メモの内容を入力してください" rows="4" cols="50"></textarea>
    
    <button type="submit">保存</button>
  </form>
</body>
</html>