<?php
include('./source.php');

$new_book_name = $_POST['new_book_name'];
$book_id = $_POST['book_id'];
$state = $_POST['state'];
$question = $_POST['question'];
$answer = $_POST['answer'];

if ($state == 'new') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        // MyBookリストの取得
        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 既存の参考書との重複チェック
        $i = 0;
        while ($i == 0) {
            foreach ($result as $row) {
                if ($row == null) {
                    break;
                } else if (($new_book_name == $row['book_name'] && $table_id == $row['table_id']) || in_array($new_book_name, $book_name_list)) {
                    header('Location: error.php?type=11', true, 307);
                    exit;
                }
            }
            break;
        }

        // book_idの生成
        $i = 0;
        while ($i == 0) {
            $book_id = rand(100000, 999999);
            $check_id = true;
            foreach ($result as $row) {
                if ((string)$book_id == $row['book_id']) {
                    $check_id = false;
                    break;
                }
            }
            if ($check_id == true) {
                break;
            }
        }

        // MyBookの追加
        $insert_data = $table_id . ', \'' . (string)$book_id . '\', \'' . $new_book_name . '\', \'\'';
        $sql = 'INSERT INTO info_my_book_index (table_id, book_id, book_name, memo) VALUES(:table_id, :book_id, :book_name, \'\')';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':book_name', $new_book_name, PDO::PARAM_STR);
        $stmt->execute();

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: error.php?type=2', true, 307);
        exit;
    }
} else if ($state == 'add') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        // 対象のMyBookを取得
        $sql = 'SELECT * FROM info_my_book_data WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // データの追加
        if ($result == false) {
            $question_number = 1;
        } else {
            $question_number = count($result) + 1;
        }
        $sql = 'INSERT INTO info_my_book_data (table_id, book_id, word, answer, question_number) VALUES(:table_id, :book_id, :word, :answer, :question_number)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':word', $question, PDO::PARAM_STR);
        $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $question_number, PDO::PARAM_INT);
        $stmt->execute();

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: error.php?type=2', true, 307);
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
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <?php echo '<p class = "main-inner-newbookname">' . $new_book_name . '</p>'; ?>
                <form  class = "main-form" method = "post" action = "make_my_book.php">
                    <div class = "main-form-inner">
                        <?php
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        echo '<input class = "info_account" type = "text" name = "state" value = "add">';
                        echo '<input class = "info_account" type = "text" name = "new_book_name" value = "' . $new_book_name . '">';
                        echo '<input class = "info_account" type = "text" name = "book_id" value = "' . $book_id . '">';
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
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
