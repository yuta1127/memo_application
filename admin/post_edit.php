<?php require_once "../system/common_admin.php";?>
<?php
// ホワイトリスト変数の作成
$whitelist = array("send", "mode", "post_id", "post_title", "post_content");
$request = whitelist($whitelist);

$page_message = ""; // ページに表示するメッセージ
$page_error = ""; // エラーメッセージ
$mode = $request["mode"]; // 動作モード（新規-指定なし/修正-change/削除-delete）

// フォーム初期値のセット
$form = array();
$form["post_id"] = $request["post_id"];
$form["post_title"] = $request["post_title"];
$form["post_content"] = $request["post_content"];

// 修正モード時はフォーム初期値をセット
if ((!isset($request["send"]) && $mode == "change") ||  $mode == "delete") {
    try {
        $stmt = $db->prepare("SELECT * FROM posts WHERE post_id = ? LIMIT 1");
        $stmt->execute(array($request["post_id"])); // クエリの実行
        $row_post = $stmt->fetch(PDO::FETCH_ASSOC); // SELECT結果を配列に格納
        if ($row_post) {
            // データ取得成功時は、フォーム初期値をセット
            if ($mode == "change") {
                $form["post_title"] = $row_post["post_title"];
                $form["post_content"] = $row_post["post_content"];
            }
        } else {
            // データ取得失敗時は停止
            exit("異常なアクセスです");
        }
    } catch (PDOException $e) {
        // エラー発生時
        exit("クエリの実行に失敗しました");
    }
}

// 削除モード
if ($mode == "delete") {
    try {
        $db->beginTransaction();
        $stmt = $db->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->execute(array($request["post_id"]));
        $db->commit();
    } catch (PDOException $e) {
        // エラー発生時
        $db->rollBack();
        exit("クエリの実行に失敗しました");
    }
    header("Location: post_list.php");
    exit;
}

// エラーチェック
if (isset($request["send"])) {
    if ($request["post_title"] == "") {
        $page_error = "記事タイトルを入力してください\n";
    }
}

// 登録実行
if (isset($request["send"]) && $page_error == "") {
    // データベースへ保存
    try {
        $db->beginTransaction();
        if ($mode == "change") {
            // 修正モード
            $stmt = $db->prepare("UPDATE posts SET post_title = ?, post_content = ? WHERE post_id = ?");
            $stmt->execute(array($request["post_title"], $request["post_content"], $request["post_id"]));
        } else {
            // $mode空白時は新規登録
            $stmt = $db->prepare("INSERT INTO posts (post_title, post_content, post_created) VALUES (?, ?, NOW())");
            $stmt->execute(array($request["post_title"], $request["post_content"]));
            $mode = "change"; // 新規作成が成功したら、修正モードにする
            $form["post_id"] = $db->lastInsertId("post_id"); // 追加したpost_idを取得する
        }
        $db->commit();
    } catch (PDOException $e) {
        // エラー発生時
        $db->rollBack();
        exit("クエリの実行に失敗しました");
    }

    // 完了
    $page_message = "登録が完了しました";
}
?>
<?php $page_title = "記事編集";?>
<?php require "header.php";?>
    <p>
      <a href="post_list.php">一覧へ戻る</a>
    </p>
    <p>
      <?php echo he($page_message); ?>
    </p>
    <p class="attention">
      <?php echo he($page_error); ?>
    </p>
<?php if ($mode == "change") {?>
    <p>
      記事ID[<?php echo he($form["post_title"]); ?>]を修正しました
    </p>
<?php }?>
    <form action="post_edit.php" method="post">
      <div>
        記事タイトル <span class="attention">[必須]</span><br>
        <input type="text" name="post_title" size="30" value="<?php echo he($form["post_title"]); ?>">
      </div>
      <div>
        記事本文<br>
        <textarea name="post_content" rows="5" cols="20"><?php echo he($form["post_content"]); ?></textarea>
      </div>
      <div>
        <input type="submit" name="send" value="登録する">
        <input type="hidden" name="mode" value="<?php echo he($mode); ?>">
        <input type="hidden" name="post_id" value="<?php echo he($form["post_id"]); ?>">
      </div>
    </form>
<?php require "footer.php";?>