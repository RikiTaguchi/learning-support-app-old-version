<!--
バナー通知コード
0 = 未登録アカウント（ログイン画面）
1 = パスワード不一致（ログイン画面）
2 = データベース接続エラー → 再ログイン要請（ログイン画面）
3 = 復習リストが空（ホーム画面）
4 = アカウント情報更新完了（アカウント情報更新画面）
5 = アカウント情報更新失敗（アカウント情報更新画面）
6 = ログアウト（ログイン画面）
7 = My単語帳作成エラー → 既存の単語帳がある（My単語帳編集画面）
8 = スタンプ取得（スタンプカード画面）
9 = API接続エラー（ホーム画面）
10 = アカウント作成エラー → 既存アカウントがある（アカウント作成画面）
11 = My単語帳作成エラー → 既存の単語帳がある（My単語帳作成画面）
12 = データベース接続エラー → 入力内容の確認要請（ホーム画面）
13 = 原因不明のエラー（ログイン画面）
14 = アカウント登録完了（ログイン画面）
15 = アカウント削除完了（ログイン画面）
16 = フォーム入力エラー（参考書）（form.php）
17 = フォーム入力エラー（数値）（form.php）
18 = フォーム入力エラー（参考書）（form2.php）
19 = フォーム入力エラー（数値）（form2.php）
20 = フォーム入力エラー（参考書）（form3.php）
21 = スタンプ有効期限切れ（スタンプカード画面）
22 = 未登録アカウント（管理者ログイン画面）
23 = パスワード不一致（管理者ログイン画面）
24 = データベース接続エラー → 再ログイン要請（管理者ログイン画面）
25 = 管理者ログイン完了（管理者ホーム画面）
26 = アカウント作成エラー → 既存アカウントがある（管理者アカウント作成画面）
27 = アカウント作成完了（管理者ログイン画面）
28 = ログアウト（管理者ログイン画面）
29 = スタンプ登録完了（スタンプ一覧画面）
30 = 管理者アカウント情報更新完了（管理者アカウント情報更新画面）
31 = 管理者アカウント情報更新失敗（管理者アカウント情報更新画面）
32 = 管理者アカウント情報削除完了（管理者ログイン画面）
33 = ユーザースタンプ削除完了（スタンプカード画面）
34 = 管理者スタンプ更新完了（スタンプ一覧画面）
35 = 管理者スタンプ削除完了（スタンプ一覧画面）
36 = フォーム入力エラー（参考書）（form9.php）
37 = フォーム入力エラー（数値）（form9.php）
38 = フォーム入力エラー（単元）（form10.php）
39 = フォーム入力エラー（難易度）（form10.php）
40 = フォーム入力エラー（数値）（form10.php）
41 = QR読み取りエラー（未ログイン）(ログイン画面)
-->

<!-- URLを修正 -->

<?php
$type = $_GET['type'];
if ($type == '3' || $type == '9' || $type == '12') {
    $url = 'Location: https://wordsystemforstudents.com/index.php?banner=' . $type;
} else if ($type == '0' || $type == '1' || $type == '2' || $type == '6' || $type == '13' || $type == '14' || $type == '15' || $type == '41') {
    $url = 'Location: https://wordsystemforstudents.com/login.html?banner=' . $type;
} else if ($type == '7') {
    $url = 'Location: https://wordsystemforstudents.com/detail.php?banner=' . $type;
} else if ($type == '10') {
    $url = 'Location: https://wordsystemforstudents.com/make_account.html?banner=' . $type;
} else if ($type == '11') {
    $url = 'Location: https://wordsystemforstudents.com/form4.php?banner=' . $type;
} else if ($type == '4' || $type == '5') {
    $url = 'Location: https://wordsystemforstudents.com/info_account.php?banner=' . $type;
} else if ($type == '16') {
    $url = 'Location: https://wordsystemforstudents.com/form.php?banner=' . $type;
} else if ($type == '17') {
    $url = 'Location: https://wordsystemforstudents.com/form.php?banner=' . $type;
} else if ($type == '18') {
    $url = 'Location: https://wordsystemforstudents.com/form2.php?banner=' . $type;
} else if ($type == '19') {
    $url = 'Location: https://wordsystemforstudents.com/form2.php?banner=' . $type;
} else if ($type == '20') {
    $url = 'Location: https://wordsystemforstudents.com/form3.php?banner=' . $type;
} else if ($type == '22' || $type == '23' || $type == '24' || $type == '27' || $type == '28' || $type == '32') {
    $url = 'Location: https://wordsystemforstudents.com/director/login_director.html?banner=' . $type;
} else if ($type == '26') {
    $url = 'Location: https://wordsystemforstudents.com/director/make_director.html?banner=' . $type;
} else if ($type == '30' || $type == '31') {
    $url = 'Location: https://wordsystemforstudents.com/director/info_director.php?banner=' . $type;
} else if ($type == '36' || $type == '37') {
    $url = 'Location: https://wordsystemforstudents.com/director/form9.php?banner=' . $type;
} else if ($type == '38') {
    $url = 'Location: https://wordsystemforstudents.com/form10.php?banner=' . $type;
} else if ($type == '39') {
    $url = 'Location: https://wordsystemforstudents.com/form10.php?banner=' . $type;
} else if ($type == '40') {
    $url = 'Location: https://wordsystemforstudents.com/form10.php?banner=' . $type;
} else {
    $url = 'Location: https://wordsystemforstudents.com/login.html?banner=13';
}
header($url, true, 307);
exit;
