<?php
$siteTitle = 'HOME';
require('head.php');
 ?>

    <body class="page-home">

      <!-- ヘッダー -->
      <?php
        require('header.php');
       ?>

    <!-- メインコンテンツ -->
    <div class="site-width" id="contents">
      <section id="main">
        <h1 class="title">メモりーとは</h1>
        <div class="explain">
        　<p>自分の思いつきや、文章として残しておきたいものをここに書き込んでおけば、後から見ることができます。<br>
             自分の考えの整理やまとめ、ちょっとしたメモにお使いください。<br>
          </p>
        </div>
          <div class="img-zone">
          <img class="img1" src="img/img2.png" alt="">
          <img class="img2" src="img/img1.png" alt="">
          </div>
      </section>

    </div>

    <!-- フッター -->
    <?php require('footer.php'); ?>
