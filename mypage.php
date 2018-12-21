<?php
//共通変数・関数を読み込み
require('function.php');

//ログイン認証
require('auth.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('マイページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

$u_id = $_SESSION['user_id'];
$dbMemoData = getMemo($u_id);

?>


 <?php
  $siteTitle = 'マイページ';
  require('head.php');
  ?>

  <body class="page-mypage">

  <!-- ヘッダー -->
  <?php
  require('header.php');
   ?>
　 <div class="site-width" id="contents">
   <h2 class="title">MYPAGE</h2>
          <!-- メインコンテンツ -->
          <section id="main">
            <sction class="memo-list">
              <?php
              if(!empty($dbMemoData)){
              foreach($dbMemoData as $key => $val):
               ?>
               <div class="memo-title"><a href="deletememo.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&memo_id='.$val['memo_id'] : '?memo_id='.$val['memo_id']; ?>" class="delete">削除</a>
                 <p><?php echo sanitize($val['memo_title']); ?></p>
               </div>
               <div class="memo">
               <p>
                 <?php echo sanitize($val['memo']); ?>
               </p>
               </div>
             <?php
            endforeach;
           } else {?>
           <a class="memo-text" href="memo.php">メモ作成</a>
           <?php } ?>
            </section>
          </section>
　 </div>

  <!-- フッター -->
  <?php
  require('footer.php');
   ?>
