<?php
require_once "common.php";


session_start();

// ログイン状態のチェック
$logined_check = false; 
if (!isset($ignore_login)) {
    // 認証用変数をsessionから取得
    if (isset($_SESSION["user_id"])) {
        $session_user_id = $_SESSION["user_id"];
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
            $stmt->execute(array($session_user_id)); // クエリの実行
            $row_user = $stmt->fetch(PDO::FETCH_ASSOC); // SELECT結果を配列に格納
            if ($row_user) {
                // 該当のuserレコードがあったらログイン状態にする
                $logined_check = true;
            }
        } catch (PDOException $e) {
            // エラー発生時
            exit("ログイン失敗");
        }
    }
    
    // ログイン状態でなかったら、ログインページへジャンプ
    if (!$logined_check) {
        header("location: login.php");
        exit;
    }
}
?>