<?php
$user = 'xs192380_taguchi';
$pass = 'gon2122RK';
$login_id = $_POST['login_id'];
$user_pass = $_POST['user_pass'];
$user_name = $_POST['user_name'];

function make_link($title, $url, $info) {
    $text_form = '';
    if (count($info) == 4) {
        $text_form = '
            <form method = "post" action = "' . $url .'">
                <input class = "info_account" type = "text" name = "user_name" value = "' . $info[0] . '">
                <input class = "info_account" type = "text" name = "login_id" value = "' . $info[1] . '">
                <input class = "info_account" type = "text" name = "user_pass" value = "' . $info[2] . '">
                <input class = "info_account" type = "text" name = "user_api_key" value = "' . $info[3] . '">
            <button class = "make-link-button" type = "submit">
                <p>' . $title . '</p>
            </button>
            </form>
        ';
    } else {
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
    }
    echo $text_form;
}
?>