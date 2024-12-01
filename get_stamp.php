<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;

    $user_table_id = $result['table_id'];
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

$director_table_id = $_GET['table_id'];
$img_id = $_GET['img_id'];
$img_extention_list = [];
$img_probability_list = [];

if ($login_id == '' || $user_pass == '') {
    if ($_GET['img_extention_0'] == '') {
        $url = 'Location: https://wordsystemforstudents.com/login.html?banner=41&table_id=' . $director_table_id . '&img_id=' . $img_id . '&img_extention=' . $_GET['img_extention'];
    } else {
        $url = 'Location: https://wordsystemforstudents.com/login.html?banner=41&table_id=' . $director_table_id . '&img_id=' . $img_id . '&img_extention_0=' . $_GET['img_extention_0'];
    }
    header($url, true, 307);
    exit;
}

if ($_GET['img_extention_0'] != '') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_image WHERE table_id = ' . $director_table_id . ' AND img_id = ' . $img_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $img_extention_list[] = $row['img_extention'];
        }

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (count($img_extention_list) == 0) {
        $sql = 'SELECT * FROM info_image WHERE table_id = ' . $director_table_id . ' AND img_id = ' . $img_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $img_extention = $result['img_extention'];
        $img_title = $result['img_title'];
        $stamp_id = 'none';
        $date_limit = strtotime($result['date_limit']);
        $date_today = strtotime(date('Y-m-d'));
    } else {
        foreach ($img_extention_list as $i => $data_extention) {
            $sql = 'SELECT * FROM info_image WHERE table_id = ' . $director_table_id . ' AND img_id = ' . $img_id . ' AND stamp_id = \'' . (string)$i . '\'';
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $img_probability_list[] = (int)$result['stamp_prob'];
            $date_limit = strtotime($result['date_limit']);
            $date_today = strtotime(date('Y-m-d'));
        }

        $result_number = rand(1, 100);
        $border_prob = 0;
        foreach ($img_extention_list as $i => $data_extention) {
            $border_prob += (int)$img_probability_list[$i];
            if ($result_number <= $border_prob) {
                $stamp_id = (string)$i;
                break;
            }
        }
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if (($date_limit - $date_today) / (60 * 60 * 24) >= 0) {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'INSERT INTO info_stamp (user_table_id, director_table_id, img_id, stamp_id, get_date) VALUE(' . $user_table_id . ', ' . $director_table_id . ', ' . $img_id . ', \'' . $stamp_id . '\', \'' . date('Y-m-d') . '\')';
        $dbh->query($sql);

        $sql = 'SELECT * FROM info_stamp';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $i => $row) {
            $sql = '';
            $sql = 'UPDATE info_stamp SET id = ' . (string)($i + 1) . ' WHERE id = ' . (string)$row['id'];
            $dbh->query($sql);
        }

        $dbh = null;

        header('Location: https://wordsystemforstudents.com/detail_stamp.php?banner=8', true, 307);
        exit;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
} else {
    header('Location: https://wordsystemforstudents.com/detail_stamp.php?banner=21', true, 307);
    exit;
}
