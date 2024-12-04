<?php
include('./source.php');
include('./info_db.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_memo = $result['memo'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>メモ帳</title>
        <meta name = "description" content = "メモ帳更新">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/memo.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <?php if ($login_id != '000000') { ?>
                <h1>メモ帳</h1>
                <div class = "main-edit-memo">
                    <div class = "main-edit-memo-inner">
                        <form class = "main-edit-memo-form" method = "post" action = "memo_edit.php">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                ?>
                                <textarea class = "main-edit-memo-text" name = "user_memo"><?php echo $user_memo; ?></textarea>
                                <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                            </div>
                            <div class = "main-edit-memo-button">
                                <button type = "submit" name = "edit_type" value = "edit">
                                    <p>更新する</p>
                                </button>
                            </div>
                            <div class = "main-edit-memo-button-delete">
                                <button type = "submit" name = "edit_type" value = "reset1">
                                    <p>リセット</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
