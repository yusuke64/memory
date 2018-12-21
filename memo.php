<?php

//共通変数・関数ファイルを読み込み
require('function.php');

//ログイン認証
require('auth.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　メモ作成ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//post送信されていた場合
if(!empty($_POST)){
  //変数にメモ情報を代入
  $memo_title = $_POST['memo-title'];
  $memo = $_POST['memo'];

  //未入力チェック
  validRequired($memo_title, 'memo-title');
  validRequired($memo, 'memo');

  if(empty($err_msg)){

    //例外処理
    try{
      //DBへ接続
      $dbh = dbConnect();
      //SQL文作成
      debug('メモ新規作成');
      $sql = 'INSERT INTO memo (memo, memo_title, user_id, login_time, create_date)
      values(:memo, :memo_title, :user_id, :login_time, :create_date)';
      $data = array(':memo' => $memo, ':memo_title' => $memo_title, ':user_id' => $_SESSION['user_id'], ':login_time' => date('Y-m-d H:i:s'), ':create_date' => date('Y-m-d H:i:s'));

      //クエリ実行
      $stmt = queryPost($dbh, $sql, $data);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION['memo_id'] = $result['memo_id'];


      //クエリ成功の場合
      if($stmt){
        debug('マイページへ遷移します');
        header("Location:mypage.php");//マイページへ
      }

      }catch(Exception $e){
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了
<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');


 ?>

<?php
 $siteTitle = 'MEMO-create';
 require('head.php');
  ?>

  <body class="page-memopage">

    <?php
      require('header.php');
     ?>

     <div id="memo" class="site-width">
       <section id="main">
        <form class="form" method="post" action="">
          <div class="area-msg">
            <?php if(!empty($err_msg['common'])) echo $err_msg['common']; ?>
          </div>
          <h2 class="title">メモ作成</h2>

         <div class="memo-title">
           <label class="<?php if(!empty($err_msg['memo-title'])) echo 'err'; ?>">
             <div class="area-msg">
               <?php if(!empty($err_msg['memo-title'])) echo $err_msg['memo-title']; ?>
             </div>
             <input type="text" name="memo-title" placeholder="タイトル" autocomplete="off" value="<?php if(!empty($_POST['memo-title'])) echo $_POST['memo-title']; ?>">
           </label>
         </div>
         <div class="memo-contents">
           <label class="<?php if(!empty($err_msg['memo'])) echo 'err'; ?>">
             <div class="area-msg">
               <?php if(!empty($err_msg['memo'])) echo $err_msg['memo']; ?>
             </div>
             <textarea id="js-count" name="memo" rows="10" cols="100" placeholder="メモ" ><?php if(!empty($_POST['memo'])) echo $_POST['memo']; ?></textarea>
             <div class="counter">
               <span class="show-count">0</span>文字
             </div>
             <input type="submit" name="" value="保存する" class="btn-mid">
           </label>
         </div>
        </form>
       </section>
     </div>

<!-- フッター -->
<?php require('footer.php'); ?>
