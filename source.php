<?php
$db_user = 'root';
$db_pass = 'myrdspassword';
$db_host = 'wordsystemdb.c74wk6yq0kc9.ap-northeast-1.rds.amazonaws.com';
$db_name = 'wordsystemdb';
$login_id = $_POST['login_id'];
$user_pass = $_POST['user_pass'];
$user_name = $_POST['user_name'];

function make_link($title, $url, $info) {
    $text_form = '
        <form method = "post" action = "' . $url .'">
            <input class = "info_account" type = "text" name = "user_name" value = "' . $info[0] . '">
            <input class = "info_account" type = "text" name = "login_id" value = "' . $info[1] . '">
            <input class = "info_account" type = "text" name = "user_pass" value = "' . $info[2] . '">
        <button class = "make-link-button" type = "submit">
            <p>' . $title . '</p>
        </button>
        </form>
    ';
    echo $text_form;
}
