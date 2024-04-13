<?php
session_start();
require('../library.php');

if (isset($_SESSION['form'])) {
	$form = $_SESSION['form'];
} else {
	header('Location: signup.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$db = dbconnect();
	if (!$db) {
		die($db->error);
	}

	$stmt = $db->prepare('insert into users (name, email, password) VALUES (?, ?, ?)');
	if (!$stmt) {
		die($db->error);
	}
	$password = password_hash($form['password'], PASSWORD_DEFAULT);
	$stmt->bind_param('sss', $form['name'], $form['email'], $password);
	$success = $stmt->execute();
	if (!$success) {
		die($db->error);
	}

	unset($_SESSION['form']);
	header('Location: entry_comp.php');
}
?>
<!-- 入力内容の確認 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>入力内容の確認</title>
  <link rel="stylesheet" href="entry_style.css">
</head>
<body>
<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
			<form action="" method="post">
				<p>名前</p>
				<p><?php echo h($form['name']); ?></p>
				<p>メールアドレス</p>
				<p><?php echo h($form['email']); ?></p>
				<p>パスワード</p>
				<p>【表示されません】</p>
				<div>
					<a href="signup.php? action=rewrite">訂正する</a> | <input type="submit" value="登録する" />
				</div>
			</form>
		</div>

	</div>
</body>
</html>