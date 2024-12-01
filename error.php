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
