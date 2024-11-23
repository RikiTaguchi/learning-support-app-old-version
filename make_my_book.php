<?php
include('./source.php');

$new_book_name = $_POST['new_book_name'];
$state = $_POST['state'];
$question = $_POST['question'];
$answer = $_POST['answer'];

if ($state == 'new') {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
        $table_name = $result['table_id'] . '_my_book_list';

        $sql = 'SELECT * FROM ' . $table_name;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        $j = 0;
        $book_name_list = ['ターゲット1900', 'システム英単語', '速読英熟語(熟語)', 'Vintage', '古文単語330', 'ターゲット1400', 'パス単(３級)', 'パス単(準２級)', 'パス単(２級)', 'パス単(準１級)'];
        while ($i == 0) {
            foreach ($result as $row) {
                if ($row == null) {
                    break;
                } else if ($new_book_name == $row['book_name'] || in_array($new_book_name, $book_name_list)) {
                    header('Location: https://wordsystemforstudents.com/error.php?type=11', true, 307);
                    exit;
                }
            }
            break;
        }

        while ($j == 0) {
            $book_id = rand(100000, 999999);
            $check_id = true;
            foreach ($result as $row) {
                if ($book_id == $row['book_id']) {
                    $check_id = false;
                    break;
                }
            }
            if ($check_id == true) {
                $insert_data = '\'' . $new_book_name . '\', \'' . $book_id . '\', \'' . '' . '\'';
                $sql = 'INSERT INTO ' . $table_name . ' VALUE(' . $insert_data . ')';
                $dbh->query($sql);

                $table_name = $table_id . '_' . $book_id;
                $sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
                    id INT(11),
                    word VARCHAR(255),
                    answer VARCHAR(255)
                )';
                $dbh->query($sql);
                break;
            }
        }

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
} else if ($state == 'add') {
    try {
        $table_name = $_POST['table_name'];
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $insert_data = '\'' . $question . '\', \'' . $answer . '\'';
        $sql = 'INSERT INTO ' . $table_name . ' (word, answer) VALUE(' . $insert_data . ')';
        $dbh->query($sql);

        $sql = 'SELECT * FROM ' . $table_name;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($result as $row) {
            $sql = 'UPDATE ' . $table_name . ' SET id = ' . (string)$i . ' WHERE word = \'' . $row['word'] . '\' AND answer = \'' . $row['answer'] . '\'';
            $dbh->query($sql);
            $i += 1;
        }

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
}

include('./banner.php');
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>My単語帳作成</title>
        <meta name = "description" content = "My単語帳作成フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/make_my_book.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <?php
                echo '<p class = "main-inner-newbookname">' . $new_book_name . '</p>';
                ?>
                <form  class = "main-form" method = "post" action = "make_my_book.php">
                    <div class = "main-form-inner">
                        <?php
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<input class = "info_account" type = "text" name = "state" value = "add">';
                        echo '<input class = "info_account" type = "text" name = "new_book_name" value = "' . $new_book_name . '">';
                        echo '<input class = "info_account" type = "text" name = "table_name" value = "' . $table_name . '">';
                        ?>
                        <div class = "main-inner-form-input">
                            <div class = "main-inner-form-input-text">
                                <p>Word:</p>
                                <input type = "text" name = "question" required>
                            </div>
                            <div class = "main-inner-form-input-text">
                                <p>Answer:</p>
                                <input type = "text" name = "answer" required>
                            </div>
                            <input class = "info-banner" type = "text" name = "info_banner" value = "add-data" style = "display: none;">
                            <p class = "main-form-submit"><input type = "submit" value = "追加"></p>
                        </div>
                    </div>
                </form>

                <div class = "main-form-inner-finish">
                    <form class = "main-form-finish" method = "post" action = "index.php">
                        <?php
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        ?>

                        <input class = "info-banner" type = "text" name = "info_banner" value = "new-book" style = "display: none;">

                        <div class = "main-form-finish-button">
                            <p class = "main-form-submit"><input type = "submit" value = "作成完了"></p>
                        </div>
                    </form>
                    <p class = "main-form-finish-msg">※単語帳の詳細は、後から編集できます。</p>
                </div>
            </div>
        </main>
        <footer class = "footer">
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>