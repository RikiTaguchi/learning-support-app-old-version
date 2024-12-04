<?php
// 管理者アカウント情報
$director_id = $_POST['director_id'];
$director_pass = $_POST['director_pass'];
$director_name = $_POST['director_name'];

// リンクを作成する関数
function make_link($title, $url, $info) {
    $text_form = '
        <form method = "post" action = "' . $url .'">
            <input type = "text" name = "director_name" style = "display: none;" value = "' . $info[0] . '">
            <input type = "text" name = "director_id" style = "display: none;" value = "' . $info[1] . '">
            <input type = "text" name = "director_pass" style = "display: none;" value = "' . $info[2] . '">
        <button class = "make-link-button" type = "submit">
            <p>' . $title . '</p>
        </button>
        </form>
    ';
    echo $text_form;
}

// 入力範囲のエラーをチェックする関数
function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0) == false) {
        return 2;
    } else {
        return 3;
    }
}
