
<?php

//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

 // ログイン認証
 require('auth.php');

 //===============================
 //ログイン画面処理
 //===============================
 //post送信されていた場合
 if(!empty($_POST)){
   debug('ポスト送信があります。');

   //変数にユーザー情報を代入
   $email = $_POST['email'];
   $pass = $_POST['pass'];

   //emailの形式チェック
   validEmail($email, 'email');
   //emailの最大文字数チェック
   validMaxLen($email, 'email');

   //パスワードの半角英数字チェック
   validHalf($pass, 'pass');
   //パスワードの最大文字数チェック
   validMaxLen($pass, 'pass');
   //パスワードの最小文字数チェック
   validMinLen($pass, 'pass');

   //未入力チェック
   validRequired($email, 'email');
   validRequired($pass, 'pass');

   if(empty($err_msg)){
     debug('バリデーションokです。');

     //例外処理
     try{
       //dbへ接続
       $dbh = dbConnect();
       //sql文作成
       $sql = 'SELECT password,id FROM users WHERE email = :email AND delete_flg = 0';
       $data = array(':email' => $email);
       //クエリ実行
       $stmt = queryPost($dbh, $sql, $data);
       //クエリ結果の値を取得
       $result = $stmt->fetch(PDO::FETCH_ASSOC);

       debug('クエリ結果の中身：'.print_r($result,true));

       //パスワード照合
       if(!empty($result) && password_verify($pass,array_shift($result))){
         debug('パスワードがマッチしました。');

         //ログイン有効期限
         $sesLimit = 60*60;
         //最終ログイン日時を現在日時に
         $_SESSION['login_date'] = time();

         //ログイン保持にチェックがある場合
         if($pass_save){
           debug('ログイン保持にチェックがあります。');
           //ログイン有効期限を30日にしてセット
           $_SESSION['login_limit'] = $sesLimit * 24 * 30;
         }else{
           debug('ログイン保持にチェックがありません。');
           //次回からログイン保持しないので、ログイン有効期限を1時間後にセット
           $_SESSION['login_limit'] = $sesLimit;
         }
         //ユーザーIDを格納
         $_SESSION['user_id'] = $result['id'];

         debug('セッションの中身：'.print_r($_SESSION,true));
         debug('マイページへ遷移します。');
         header("Location:mypage.php");//マイページへ
       }else{
         debug('パスワードがアンマッチです。');
         $err_msg['common'] = MSG09;
       }
     }catch(Exception $e){
       error_log('エラー発生：'.$e->getMessage());
       $err_msg['common'] = MSG07;
     }
    }

 }
 debug('画面表示処理終了<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');

 ?>

<?php
$siteTitle = 'ログイン';
require('head.php');
 ?>

    <body class="page-login">

       <!-- ヘッダー -->
      <?php require('header.php'); ?>

      <!--  メインコンテンツ -->
      <div class="site-width" id="contents">

        <section id="main">

          <div class="form-container">

            <form class="form" action="" method="post">
              <h2 class="title">ログイン</h2>
                 <div class="area-msg">
                   <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
                 </div>
                 <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
                   <p>メールアドレス</p><div class="area-msg"><?php if(!empty($err_msg['email'])) echo $err_msg['email']; ?></div>
                   <input type="text" autocomplete="off" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
                 </label>
                 <label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
                   <p>パスワード</p><div class="area-msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></div>
                   <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
                 </label>
                 <input type="submit" name="submit" value="ログイン" class="btn btn-mid">
            </form>
          </div>
        </section>
      </div>

<?php require('footer.php'); ?>
