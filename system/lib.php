<?php
// htmlentitiesのショートカット関数
function he($str){
    return htmlentities($str, ENT_QUOTES, "UTF-8");
}

// ホワイトリストによる変数抽出
function whitelist($list){
    $request = array(); // 配列の初期化
    foreach ($list as $word) { // $whitelistの中身を繰り返し
        $request[$word] = null; // nullという空白値を初期値にする
        if (isset($_REQUEST[$word])) { // 送信されてきた値の存在確認
            $word = str_replace("\0", "", $word); // ヌルバイト除去
            $request[$word] = $_REQUEST[$word]; // 明示された変数のみ$requestに格納
        }
    }
    return $request;
}
