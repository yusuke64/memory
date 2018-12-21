<?php
//メモ削除「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「

require('function.php');

//メモid取得
$memo_id = (!empty($_GET['memo_id'])) ? $_GET['memo_id'] : '';

if(!empty($memo_id) && empty($dbMemoData)){
    debug('GETパラメータのメモIDが違います。マイページへ遷移します。');
    header("Location:mypage.php"); //マイページへ
}

if(!empty($memo_id)){
    try{
        $dbh = dbConnect();

        $sql = 'UPDATE memo SET delete_flg = 1 WHERE memo_id = :memo_id';

        $data = array(':memo_id' => $memo_id);

        $stmt = queryPost($dbh, $sql, $data);

        if($stmt){
            debug('メモ削除完了');
            header('Location:mypage.php');
        }else{
            debug('クエリが失敗しました。');
        }
    }catch(Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        header('Location:mypage.php');
        $err_msg['common'] = MSG07;
    }
}


header('Location:mypage.php');
