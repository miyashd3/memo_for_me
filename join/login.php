<?php
require('../library.php');
session_start();

$error = [];
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if ($email === '' || $password === '') {
    $error['login'] = 'blank';
  } else {
    $db = dbconnect();
    $stmt = $db->prepare('select id, name, password from users where email=? limit 1');
    if (!$stmt) {
      die($db->error);
    }

    $stmt->bind_param('s', $email);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }

    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
      session_regenerate_id();
      $_SESSION['id'] = $id;
      $_SESSION['name'] = $name;
      header('Location: ../userpage/index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login_signup_style.css">
  <title>ログイン</title>
</head>
<body>
  
  <fieldset>
    <h1>ログイン</h1>
    <form action="" method="post">
        <div class="iconUser"></div>
        <input type="text" name="email" size="35" maxlength="255" placeholder="email" required value="<?php echo h($email); ?>">
        <div></div>
        <div class="iconPassword"></div>
        <input type="password" name="password" size="35" maxlength="255" placeholder="Password" required">
        <?php if (isset($error['login']) && $error['login'] === 'blank'): ?>
          <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
        <?php endif; ?>
        <?php if (isset($error['login']) && $error === 'failed'): ?>
          <p class="error">* メールアドレスとパスワードをご記入ください</p>
        <?php endif; ?>
        <input type="submit" value="Enter">
    </form>
  </fieldset>

  <div class="menu">
    <a href="signup.php"><button>新規登録</button></a>
    <a href="../index.html"><button>topページ</button></a>
  </div>
</body>
</html>

