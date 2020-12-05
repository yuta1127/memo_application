<?php $ignore_login = true;?>
<?php require_once "../system/common_admin.php";?>
<?php
// ホワイトリスト変数の作成
$whitelist = array("send", "user_loginid", "user_password");
$request = whitelist($whitelist);

$page_message = ""; // ページに表示するメッセージ
$page_error = ""; // エラーメッセージ

// エラーチェック
if (isset($request["send"])) {
    if ($request["user_loginid"] == "") {
        $page_error .= "ログインIDを入力してください\n";
    }
    if ($request["user_password"] == "") {
        $page_error .= "パスワードを入力してください\n";
    }
}

// ログイン実行
if (isset($request["send"]) && $page_error == "") {
    try {
        // ログインIDでSELECT
        $stmt = $db->prepare("SELECT * FROM users WHERE user_loginid = ? LIMIT 1");
        $stmt->execute(array($request["user_loginid"])); // クエリの実行
        $row_user = $stmt->fetch(PDO::FETCH_ASSOC); // SELECT結果を配列に格納
        if ($row_user) {
            // 該当のuserレコードがあったら、パスワードを照合
            if (sha1($request["user_password"]) == $row_user["user_password"]) {
                $_SESSION["user_id"] = $row_user["user_id"];
                header("Location: index.php");
                exit;
            }
        }
        $page_error .= "入力内容をご確認ください\n";
    } catch (PDOException $e) {
        // エラー発生時
        exit("ログイン処理に失敗しました");
    }
}
?>
<?php $page_title = "ログイン";?>
<?php require "header.php";?>
    <p class="attention">
      <?php echo nl2br(he($page_error)); ?>
    </p>
    <form action="login.php" method="post">
      <div>
        ログインID<br>
        <input type="text" name="user_loginid" size="30" value="">　　
      </div>
      <div>
        パスワード<br>
        <input type="password" name="user_password" size="30" value="">
      </div>
      <div>
        <input type="submit" class="btn btn-primary" value="ログインする">
      </div>
    </form>


