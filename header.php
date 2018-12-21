<header>
    <h1><a href="index.php">メモりー</a></h1>
    <div class="menu-trigger js-toggle-sp-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav id="top-nav" class="js-toggle-sp-menu-target">
      <ul>
        <?php if(empty($_SESSION['user_id'])){ ?>
          <li><a href="signup.php" class="btn btn-primary">ユーザー登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        <?php }else{ ?>
          <li><a href="logout.php">ログアウト</a></li>
          <li><a href="memo.php">メモ作成</a></li>
          <li><a href="mypage.php">マイページ</a></li>
        <?php } ?>
      </ul>
    </nav>
</header>
