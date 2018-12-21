<?php

//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('ユーザー登録ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//post送信されていた場合
if(!empty($_POST)){

   //変数にユーザー情報を代入
   $email = $_POST['email'];
   $pass = $_POST['pass'];
   $pass_re = $_POST['pass_re'];

   //未入力チェック
   validRequired($email, 'email');
   validRequired($pass, 'pass');
   validRequired($pass_re, 'pass_re');

   if(empty($err_msg)){

  //emailの形式チェック
  validEmail($email, 'email');
  //emailの最大文字数チェック
  validMaxLen($email, 'email');
  //email重複チェック
  validEmailDup($email);

  //パスワードの半角英数字チェック
  validHalf($pass, 'pass');
  //パスワードの最大文字数チェック
  validMaxLen($pass, 'pass');
  //パスワードの最小文字数チェック
  validMinLen($pass, 'pass');

  if(empty($err_msg)){

    //パスワードとパスワード再入力が合っているかチェック
    validMatch($pass, $pass_re, 'pass_re');

    if(empty($err_msg)){

      //例外処理
      try {
        // DBへ接続
        $dbh = dbConnect();
        // SQL文作成
        $sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
        $data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                      ':login_time' => date('Y-m-d H:i:s'),
                      ':create_date' => date('Y-m-d H:i:s'));
        // クエリ実行
        $stmt = queryPost($dbh, $sql, $data);

        // クエリ成功の場合
        if($stmt){
          //ログイン有効期限（デフォルトを１時間とする）
          $sesLimit = 60*60;
          // 最終ログイン日時を現在日時に
          $_SESSION['login_date'] = time();
          $_SESSION['login_limit'] = $sesLimit;
          // ユーザーIDを格納
          $_SESSION['user_id'] = $dbh->lastInsertId();

          debug('セッション変数の中身：'.print_r($_SESSION,true));

          header("Location:mypage.php"); //マイページへ
        }

      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = MSG07;
      }

    }
  }
}
}
?>



<?php
  $siteTitle = 'ユーザー登録';
  require('head.php');
?>

  <body class="page-signup page-1colum">

    <!-- ヘッダー -->
    <?php
      require('header.php');
    ?>

    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">

      <!-- Main -->
      <section id="main" >

        <div class="form-container">

          <form action="" method="post" class="form">
            <h2 class="title">ユーザー登録</h2>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['common'])) echo $err_msg['common'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
              <p>Email</p>  <div class="area-msg">
                  <?php
                  if(!empty($err_msg['email'])) echo $err_msg['email'];
                  ?>
                </div>
              <input type="text" name="email" autocomplete="off" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">

            </label>

            <div class="form-pass">
            <label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
              <p>パスワード</p> <span class="pass-max" style="font-size:12px">※英数字６文字以上</span><div class="area-msg">
                <?php
                if(!empty($err_msg['pass'])) echo $err_msg['pass'];
                ?>
              </div>
              <input type="password" name="pass" class="pass" autocomplete="off" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
            </label>
            </div>

            <label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
              <p>パスワード（再入力）</p><div class="area-msg">
                <?php
                if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
                ?>
              </div>
              <input type="password" name="pass_re" autocomplete="off" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
            </label>

            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="登録する">
            </div>
          </form>
        </div>

      </section>

    </div>

    <!-- footer -->
    <?php
      require('footer.php');
    ?>
