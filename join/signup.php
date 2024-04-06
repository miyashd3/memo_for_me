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
    <form>
        <div class="iconUser"></div>
        <div class="user">
          <input type="text" placeholder="name" required>
          <input type="text" class="email" placeholder="email" required>
        </div>
        <p class="error">* 名前を入力してください</p>
        <p class="error">* メールアドレスを入力してください</p>
        <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
        <div class="iconPassword"></div>
        <input type="password" placeholder="Password" required>
        <p class="error">* パスワードを入力してください</p>
        <p class="error">* パスワードは4文字以上で入力してください</p>
        <input type="submit" value="登録する">
    </form>
  </fieldset>
</body>
</html>
