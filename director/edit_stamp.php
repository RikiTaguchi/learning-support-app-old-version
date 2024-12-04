<?php
include('./source.php');
include('../info_db_.php');

$stamp_table_id = $_POST['stamp_table_id'];
$stamp_img_id = $_POST['stamp_img_id'];

$img_title_new = $_POST['img_title'];
$date_limit_new = $_POST['date_limit'];

$stamp_number = (int)$_POST['stamp-number'];

$img_extention = '';
$file_path = '';

if ($stamp_number === 1) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_image WHERE table_id = \'' . $stamp_table_id . '\' AND img_id = \'' . $stamp_img_id . '\'';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $img_extention_delete = $result['img_extention'];

        if ($_POST['stamp-info-input'] == 'none') {
            $sql = 'UPDATE info_image SET img_title = \'' . $img_title_new . '\', date_limit = \'' . $date_limit_new . '\' WHERE table_id = \'' . (string)$stamp_table_id . '\' AND img_id = \'' . (string)$stamp_img_id . '\'';
        } else {
            $img_extention = explode('.', $_FILES['img_data']['name'])[1];
            $file_path = './images_stamp/' . (string)$stamp_table_id . '_' . (string)$stamp_img_id . '.' . $img_extention;
            $file_path_delete = './images_stamp/' . (string)$stamp_table_id . '_' . (string)$stamp_img_id . '.' . $img_extention_delete;
            unlink($file_path_delete);
            move_uploaded_file($_FILES['img_data']['tmp_name'], $file_path);
            $sql = 'UPDATE info_image SET img_extention = \'' . $img_extention . '\', img_title = \'' . $img_title_new . '\', date_limit = \'' . $date_limit_new . '\' WHERE table_id = \'' . (string)$stamp_table_id . '\' AND img_id = \'' . (string)$stamp_img_id . '\'';
            $img_extention = '';
            $file_path = '';
        }

        $dbh->query($sql);
        $dbh = null;

        header('Location: detail_stamp.php?banner=34', true, 307);
        exit;
    } catch (PDOException $e) {
        header('Location: ../error.php?type=24', true, 307);
        exit;
    }
} else {
    for ($i = 0; $i < $stamp_number; $i += 1) {
        try {
            $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT * FROM info_image WHERE table_id = \'' . $stamp_table_id . '\' AND img_id = \'' . $stamp_img_id . '\' AND stamp_id = \'' . (string)$i . '\'';
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $img_extention_delete = $result['img_extention'];
    
            if ($_POST['stamp-info-input-' . (string)$i] == 'none') {
                $sql = 'UPDATE info_image SET img_title = \'' . $img_title_new . '\', date_limit = \'' . $date_limit_new . '\' WHERE table_id = \'' . (string)$stamp_table_id . '\' AND img_id = \'' . (string)$stamp_img_id . '\' AND stamp_id = \'' . (string)$i . '\'';
            } else {
                $img_extention = explode('.', $_FILES['img_data_' . (string)$i]['name'])[1];
                $file_path = './images_stamp/' . (string)$stamp_table_id . '_' . (string)$stamp_img_id . '_' . (string)$i . '.' . $img_extention;
                $file_path_delete = './images_stamp/' . (string)$stamp_table_id . '_' . (string)$stamp_img_id . '_' . (string)$i . '.' . $img_extention_delete;
                unlink($file_path_delete);
                move_uploaded_file($_FILES['img_data_' . (string)$i]['tmp_name'], $file_path);
                $sql = 'UPDATE info_image SET img_extention = \'' . $img_extention . '\', img_title = \'' . $img_title_new . '\', date_limit = \'' . $date_limit_new . '\' WHERE table_id = \'' . (string)$stamp_table_id . '\' AND img_id = \'' . (string)$stamp_img_id . '\' AND stamp_id = \'' . (string)$i . '\'';
                $img_extention = '';
                $file_path = '';
            }
    
            $dbh->query($sql);
            $dbh = null;
        } catch (PDOException $e) {
            header('Location: ../error.php?type=24', true, 307);
            exit;
        }
    }

    header('Location: detail_stamp.php?banner=34', true, 307);
    exit;
}
