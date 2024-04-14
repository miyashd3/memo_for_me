<?php
session_start();
require('../library.php');

// セッションに入力が保存されていればフォームに再表示する
if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  $form = [
    'name' => '',
    'email' => '',
    'password' => '',
  ];
}
$error = [];

// formの内容チェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if ($form['name'] === '') {
    $error['name'] = 'blank';
  }

  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  if ($form['email'] === '') {
    $error['email'] = 'blank';
  } else {
    $db = dbconnect();
    $stmt = $db->prepare('select count(*) from users where email=?');
    if(!$stmt) {
      die($db->error);
    }
    $stmt->bind_param('s', $form['email']);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }

    $stmt->bind_result($cnt);
    $stmt->fetch();

    if ($cnt > 0) {
      $error['email'] = 'duplicate';
    }
  }

  $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if($form['password'] === '') {
    $error['password'] = 'blank';
  } else if (strlen($form['password'] ?? '') < 4) {
    $error['password'] = 'length';
  }

  if (empty($error)) {
    $_SESSION['form'] = $form;

    header('Location: check.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login_signup_style.css">
  <title>会員登録</title>
</head>
<body>
  
  <fieldset>
    <h1>会員登録</h1>
    <form action="" method="POST">
        <div class="iconUser"></div>
        <div class="user">
          <input type="text" name="name" size="35" maxlength="255" value="<?php echo h($form['name']); ?>" placeholder="name"/>
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($form['email']); ?>" placeholder="email"/>
        </div>
        <?php if (isset($error['email']) && $error['email'] === 'duplicate'): ?>
          <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
        <?php endif; ?>
        <div class="iconPassword"></div>
        <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($form['password']) ?>" placeholder="password"/>
        <?php if(isset($error['password']) && $error['password'] === 'length'): ?>
          <p class="error">* パスワードは4文字以上で入力してください</p>
        <?php endif; ?>
        <input type="submit" value="登録する">
    </form>
  </fieldset>
  <div class="menu">
    <a href="login.php"><button>ログイン</button></a>
    <a href="../index.html"><button>topページ</button></a>
  </div>
</body>
</html>
