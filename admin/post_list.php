<?php require_once "../system/common_admin.php";?>
<?php
// データの問い合わせ
$rows_post = array(); // 配列の初期化
try {
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY post_created DESC");
    $stmt->execute(); // クエリの実行
    $rows_post = $stmt->fetchAll(); // SELECT結果を二次元配列に格納
} catch (PDOException $e) {
    // エラー発生時
    exit("クエリの実行に失敗しました");
}
?>
<?php $page_title = "記事管理";?>
<?php require "header.php";?>
    <a href="post_edit.php">記事を新規作成</a>
    <hr>
<?php if ($rows_post) {?>
    <table border="1" width="100%">
      <tr>
        <th></th>
        <th>タイトル</th>
        <th>本文</th>
        <th>更新日時</th>
        <th>作成日時</th>
        <th></th>
      </tr>
<?php     foreach ($rows_post as $row_post) {;?>
      <tr>
        <td><a href="post_edit.php?mode=change&post_id=<?php echo he($row_post["post_id"]);?>">編集</a></td>
        <td><?php echo he($row_post["post_title"]);?></td>
        <td><?php echo nl2br(he($row_post["post_content"]));?></td>
        <td><?php echo he($row_post["post_updated"]);?></td>
        <td><?php echo he($row_post["post_created"]);?></td>
        <td><a href="post_edit.php?mode=delete&post_id=<?php echo he($row_post["post_id"]);?>">削除</a></td>
      </tr>
<?php     }?>
    </table>
<?php }?>
<?php require "footer.php";?>