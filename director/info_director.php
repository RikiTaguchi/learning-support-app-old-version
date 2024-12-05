<?php
include('./source.php');
include('../info_db.php');

if ($_POST['new_director_id'] == '') {
    $director_id = $_POST['director_id'];
} else {
    $director_id = $_POST['new_director_id'];
}

if ($_POST['new_director_pass'] == '') {
    $director_pass = $_POST['director_pass'];
} else {
    $director_pass = $_POST['new_director_pass'];
}

if ($_POST['new_director_name'] == '') {
    $director_name = $_POST['director_name'];
} else {
    $director_name = $_POST['new_director_name'];
}

if ($director_id == '' || $director_pass == '') {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    $dbh = null;
} catch (PDOException $e) {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}

include('../banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>管理者アカウント情報</title>
        <meta name = "description" content = "管理者アカウント情報">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/info-director.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/set-banner.js"></script>
        <script src = "./js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h1>アカウント情報</h1>
                <div class = "main-info-account">
                    <div class = "main-info-account-inner">
                        <form class = "main-info-form" method = "post" action = "edit_director.php">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "director_name" value = "' . $director_name . '">';
                                echo '<input class = "info_account" type = "text" name = "director_id" value = "' . $director_id . '">';
                                echo '<input class = "info_account" type = "text" name = "director_pass" value = "' . $director_pass . '">';
                                ?>
                                <p class = "main-info-form-text">管理者名</p>
                                <?php echo '<input type = "text" name = "new_director_name" value = "' . $director_name . '" required>' ?>
                                <p class = "main-info-form-text">管理者ID</p>
                                <?php echo '<input type = "text" name = "new_director_id" value = "' . $director_id . '" required>' ?>
                                <p class = "main-info-form-text">パスワード</p>
                                <?php echo '<input type = "text" name = "new_director_pass" value = "' . $director_pass . '" required>' ?>
                                <br>
                            </div>
                            <div class = "main-info-button">
                                <button type = "submit">
                                    <p>変更する</p>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class = "main-info-account-delete">
                        <form method = "post" action = "delete_director.php" onSubmit = "return checkSubmit2()">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "director_name" value = "' . $director_name . '">';
                                echo '<input class = "info_account" type = "text" name = "director_id" value = "' . $director_id . '">';
                                echo '<input class = "info_account" type = "text" name = "director_pass" value = "' . $director_pass . '">';
                                ?>
                                <button class = "delete-text" type = "submit">
                                    <p>削除する</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
