<?php
include('./source2.php');

if ($director_id == 'removed' || $director_pass == 'removed' || $director_name == 'removed') {
    header('Location: https://wordsystemforstudents.com/error.php?type=22', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $director_name = $result['director_name'];
    $table_id = $result['table_id'];
    
    if ($director_pass != $result['director_pass']) {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=23', true, 307);
        exit;
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}

include('../banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>ホーム</title>
        <meta name = "description" content = "管理者ホーム画面">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/index_director.css" rel = "stylesheet">
        <script src = "./js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header2.php');
            ?>
        </header>

        <main class = "main">
            <div class = "main-inner">
                <h1>管理者メニュー</h1>

                <form class = "main-inner-detail" method = "POST" action = "./form9.php">
                    <button type = "submit">テスト作成</button>
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                </form>

                <form class = "main-inner-make" method = "POST" action = "./form7.php">
                    <button type = "submit">スタンプ作成</button>
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                </form>

                <form class = "main-inner-detail" method = "POST" action = "./detail_stamp.php">
                    <button type = "submit">スタンプ一覧</button>
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                </form>

                <form class = "main-inner-info-director" method = "POST" action = "./info_director.php">
                    <button type = "submit">アカウント情報</button>
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                </form>

                <form class = "main-inner-logout" method = "POST" action = "./login_director.html?banner=28">
                    <button type = "submit">ログアウト</button>
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                </form>
            </div>
        </main>

        <footer class = "footer">
            <?php
            include('./footer2.php');
            ?>
        </footer>
    </body>
</html>