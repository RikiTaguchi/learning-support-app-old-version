<?php
require_once "phpqrcode/qrlib.php";

$user = 'xs192380_taguchi';
$pass = 'gon2122RK';

$table_id = $_GET['table_id'];
$img_id = $_GET['img_id'];

$img_extention = $_GET['img_extention_0'];

$img_info = 'table_id=' . $table_id . '&img_id=' . $img_id . '&img_extention_0=' . $img_extention;
$get_stamp_url = 'https://wordsystemforstudents.com/get_stamp.php?' . $img_info;

$qr_name = $table_id . '_' . $img_id . '_qr.png';
$qr_path = './images_qr/' . $qr_name;

QRcode::png($get_stamp_url, $qr_path, QR_ECLEVEL_H);

header('Content-Type: image/png');
readfile($qr_path);
?>