<?php
include('./source.php');

$date_today = strtotime(date('Y-m-d'));
$notice = [];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_name = $result['user_name'];
    $user_api_key = $result['api_key'];
    $user_memo = $result['memo'];
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_notice';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    foreach ($result as $row) {
        $notice[] = $row;
    }
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if ($login_id != '000000') {
    $count_list = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $count_list2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $book_list = ['target_1400', 'target_1900', 'system_English', 'rapid_Reading', 'Vintage', 'pass_3', 'pass_pre2', 'pass_2', 'pass_pre1', 'pass_1', 'get_Through_2600', 'meiko_original_1', 'meiko_original_2', 'gold_phrase', 'kobun300', 'kobun315', 'kobun330'];
    $book_list2 = ['ターゲット1400', 'ターゲット1900', 'システム英単語', '速読英熟語(熟語)', 'Vintage', 'パス単(３級)', 'パス単(準２級)', 'パス単(２級)', 'パス単(準１級)', 'パス単(１級)', 'ゲットスルー2600', '明光暗記テキスト(単語)', '明光暗記テキスト(文法)', 'TOEIC金のフレーズ', 'みるみる古文単語300', '古文単語315', '古文単語330'];
    $book_id = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $default_count = 17;
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
        $table_name = $result['table_id'] . '_feedback';
        $my_list_id = $table_id . '_my_book_list';

        $sql = 'SELECT * FROM ' . $my_list_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $count_list[] = 0;
            $count_list2[] = 0;
            $book_list[] = $table_id . '_' . $row['book_id'];
            $book_list2[] = $row['book_name'];
            $book_id[] = $row['book_id'];
        }

        $sql = 'SELECT * FROM ' . $table_name;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            for ($i = 0; $i < count($book_list); $i += 1) {
                if ($row['book_name'] == $book_list[$i]) {
                    $count_list[$i] += 1;
                }
            }
        }

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }

    $my_book_name_list = [];
    $my_book_id_list = [];
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];
        $my_list_id = $table_id . '_my_book_list';

        $sql = 'SELECT * FROM ' . $my_list_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $my_book_name_list[] = $row['book_name'];
            $my_book_id_list[] = $row['book_id'];
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
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "単語システムトップページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/index.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/set-banner.js"></script>
        <script src = "./js/check-submit.js"></script>
		<script>
            const button = new Array(<? echo (string)count($notice); ?>);
            const detail = new Array(<? echo (string)count($notice); ?>);

			<?php foreach ($notice as $i => $info) { ?>
				window.addEventListener('load', () => {
                    button[<? echo (string)$i; ?>] = document.querySelector(<? echo '\'.main-notice-button-' . (string)$info['id'] . '\''; ?>);
                    detail[<? echo (string)$i; ?>] = document.querySelector(<? echo '\'.main-notice-detail-' . (string)$info['id'] . '\''; ?>);
                    detail[<? echo (string)$i; ?>].style.display = 'none';

                    const options = {
                        duration: 250,
                        easing: 'ease',
                        fill: 'forwards',
                    };

                    const openDetail = {
                        opacity: [0, 1],
                    };

                    button[<? echo (string)$i; ?>].addEventListener('click', () => {
                        if (detail[<? echo (string)$i; ?>].style.display === 'none') {
                            detail[<? echo (string)$i; ?>].style.display = 'block';
                            detail[<? echo (string)$i; ?>].animate(openDetail, options);
                        } else {
                            detail[<? echo (string)$i; ?>].style.display = 'none';
                        }
                    });
                });
			<?php } ?>
		</script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <?php if ($login_id != '000000') { ?>
            
            <div class = "main-countdown">
                <?php
                if ($user_countdown_title != '' && $user_countdown_date != strtotime('0000-00-00') && ($user_countdown_date - $date_today) / (60 * 60 * 24) >= 0) {
                    echo '<div class = "main-countdown-block1">';
                        echo '<p class = "main-countdown-text1">' . $user_countdown_title . '</p>';
                        echo '<p class = "main-countdown-text2">まで</p>';
                    echo '</div>';
                    echo '<div class = "main-countdown-block2">';
                        echo '<p class = "main-countdown-text3">あと</p>';
                        echo '<p class = "main-countdown-text4">' . ($user_countdown_date - $date_today) / (60 * 60 * 24) . '</p>';
                        echo '<p class = "main-countdown-text5">日！</p>';
                    echo '</div>';
                } else {
                    echo '<p class = "main-countdown-text6">ここに日程を登録すると、カウントダウンされます。</p>';
                }
                ?>

                <div class = "main-countdown-area-button">
                    <form class = "main-countdown-form" method = "post" action = "countdown_set.php">
                        <div>
                            <?php
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            ?>
                        </div>
                        <div class = "main-countdown-button">
                            <button type = "submit">
                                <?php
                                if ($user_countdown_title != '' && $user_countdown_date != strtotime('0000-00-00') && ($user_countdown_date - $date_today) / (60 * 60 * 24) >= 0) {
                                    echo '<p>編集</p>';
                                } else {
                                    echo '<p>登録</p>';
                                }
                                ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class = "main-notice">
                <p class = "main-notice-title">お知らせ</p>
                <?php
                echo '<div class = "main-notice-list">';
                    for ($i = count($notice) - 1; $i >= 0; $i -= 1) {
                        echo '<div class = "main-notice-list-block">';
							echo '<div class = "main-notice-list-subblock">';
								echo '<p class = "main-notice-subtitle">' . $notice[$i]['title'] . '</p>';
								echo '<p class = "main-notice-date">' . $notice[$i]['date'] . '</p>';
								echo '<button class = "main-notice-button-root main-notice-button-' . (string)$notice[$i]['id'] . '"><p>詳細</p></button>';
							echo '</div>';
							echo '<div class = "main-notice-detail-root main-notice-detail-' . (string)$notice[$i]['id'] . '"><p>' . $notice[$i]['detail'] . '</p></div>';
						echo '</div>';
						echo '<hr class = "main-notice-line">';
                    }
                echo '</div>';
                ?>
            </div>

            <div class = "main-memo">
                <p class = "main-memo-title">メモ帳</p>

                <div class = "main-memo-element">
                    <?php
                    if ($user_memo == '') {
                        echo '<p>目標や予定を書き込み、有効に活用しましょう！</p>';
                    } else {
                        echo '<p>' . nl2br($user_memo) . '</p>';
                    }
                    ?>
                </div>

                <div class = "main-memo-area-button">
                    <form class = "main-memo-form" method = "post" action = "memo_set.php">
                        <div>
                            <?php
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            ?>
                        </div>
                        <div class = "main-memo-button2">
                            <button type = "submit">
                                <p>編集</p>
                            </button>
                        </div>
                    </form>
                    <form class = "main-memo-form" method = "post" action = "memo_edit.php">
                        <div>
                            <?php
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            ?>

                            <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">

                        </div>
                        <div class = "main-memo-button1">
                            <button type = "submit" name = "edit_type" value = "reset2">
                                <p>リセット</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class = main-table-inner>
                    <div class = "main-table-block1">
                        <p class = "main-title-feedback">復習リスト</p>
                        <div class = main-feedback-table>
                            <?php
                            if ($count_list != $count_list2) {
                                echo '<table>';
                                for ($i = 0; $i < count($book_list); $i += 1) {
                                    if ($count_list[$i] > 0) {
                                        echo '<tr>';
                                        echo '<td class = "main-table-element title1">' . $book_list2[$i] . '</td>' . PHP_EOL;
                                        echo '<td class = "main-table-element title2">' . $count_list[$i] . '題</td>' . PHP_EOL;
                                        if ($i < $default_count) {
                                            $text_form = '
                                                <td class = "main-table-button-blue">
                                                <form method = "post" action = "feedback.php">
                                                    <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                                    <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                                    <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                                    <input class = "info_account" type = "text" name = "book_name" value = "' . ($i + 1) . '">
                                                    <input class = "info_account" type = "text" name = "order" value = "1">
                                                <button class = "make-link-button2" type = "submit">
                                                    <p>復習</p>
                                                </button>
                                                </form>
                                                </td>
                                            ';
                                        } else {
                                            $text_form = '
                                                <td class = "main-table-button-blue">
                                                <form method = "post" action = "feedback.php">
                                                    <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                                    <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                                    <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                                    <input class = "info_account" type = "text" name = "book_name" value = "' . ($book_id[$i]) . '">
                                                    <input class = "info_account" type = "text" name = "order" value = "1">
                                                <button class = "make-link-button2" type = "submit">
                                                    <p>復習</p>
                                                </button>
                                                </form>
                                                </td>
                                            ';
                                        }
                                        echo $text_form . PHP_EOL;
                                        $text_form = '
                                            <td class = "main-table-button-red">
                                            <form method = "post" action = "feedback_delete.php" onSubmit = "return checkSubmit()">
                                                <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                                <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                                <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                                <input class = "info_account" type = "text" name = "db_name" value = "' . $book_list[$i] . '">
                                                <input class = "info_account" type = "text" name = "delete_all" value = "all">
                                                <input class = "info-banner" type = "text" name = "info_banner" value = "delete" style = "display: none;">
                                            <button class = "make-link-button2" type = "submit">
                                                <p>削除</p>
                                            </button>
                                            </form>
                                            </td>
                                        ';
                                        echo $text_form . PHP_EOL;
                                        echo '</tr>';
                                    }
                                }
                                echo '</table>';
                            } else {
                                echo '復習リストは空です。';
                            }
                            ?>
                        </div>
                    </div>

                    <div class = "main-table-block2">
                        <p class = "main-title-mybook">My単語帳</p>
                        <div class = main-mybook-table>
                            <?php
                            if ($my_book_id_list != null) {
                                echo '<table>';
                                    for ($i = 0; $i < count($my_book_name_list); $i += 1) {
                                        echo '<tr>';
                                        echo '<td class = "main-table-element title3">' . $my_book_name_list[$i] . '</td>';
                                        $text_form = '
                                            <td class = "main-table-button-blue">
                                            <form method = "post" action = "detail.php">
                                                <input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">
                                                <input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">
                                                <input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">
                                                <input class = "info_account" type = "text" name = "table_id" value = "' . $table_id . '">
                                                <input class = "info_account" type = "text" name = "my_book_name" value = "' . $my_book_name_list[$i] . '">
                                                <input class = "info_account" type = "text" name = "my_book_id" value = "' . $my_book_id_list[$i] . '">
                                            <button class = "make-link-button2" type = "submit">
                                                <p>編集する</p>
                                            </button>
                                            </form>
                                            </td>
                                        ';
                                        echo $text_form;
                                        echo '</tr>';
                                    }
                                echo '</table>';
                            } else {
                                echo '<p class = "main-msg-nobook">My単語帳が登録されていません。</p>';
                                echo '<div class = "main-mybook-area-add">';
                                echo '<form class = "main-mybook-button-add" method = "post" action = "form4.php">';
                                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                    echo '<button class = "main-mybook-button-add-button" type = "submit">';
                                        echo '<p>登録する</p>';
                                    echo '</button>';
                                echo '</form>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            } else {
                echo '<div class = "main-msg"><p class = "main-msg-p">ゲストモードでは復習機能・My単語帳機能・AIサポート機能が利用できません。</p></div>';
            }
            ?>
        </main>
        <footer class = "footer">
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>