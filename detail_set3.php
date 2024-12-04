<?php
include('./source.php');
include('./info_db.php');

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$new_book_name = $_POST['new_book_name'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 既存book_nameとの重複チェック
    $check_book_name = false;
    foreach ($result as $row) {
        if ($row == null) {
            break;
        } else if ($new_book_name == $row['book_name'] && $book_id != $row['book_id']) {
            $check_book_name = true;
            break;
        }
    }

    if ($check_book_name == true) {
        $dbh = null;
        if ($_POST['info_banner'] == 'update') {
            header('Location: error.php?type=7', true, 307);
            exit;
        } else {
            header('Location: error.php?type=11', true, 307);
            exit;
        }
    } else {
        // book_nameの更新
        $sql = 'UPDATE info_my_book_index SET book_name = :book_name_new WHERE table_id = :table_id AND book_id = :book_id AND book_name = :book_name_pre';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':book_name_new', $new_book_name, PDO::PARAM_STR);
        $stmt->bindParam(':book_name_pre', $book_name, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
        header('Location: detail.php', true, 307);
    }
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
