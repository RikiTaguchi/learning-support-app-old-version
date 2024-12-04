<?php
include('./source.php');
include('../info_db_.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    if ($director_pass != $result['director_pass']) {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
        exit;
    }

    $sql = 'SELECT * FROM info_image WHERE table_id = \'' . $table_id . '\' AND stamp_state = \'valid\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $img_list = $result;

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
        <title>スタンプ一覧</title>
        <meta name = "description" content = "管理者ログイン">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/detail_stamp.css" rel = "stylesheet">
        <script src = "./js/set-banner.js"></script>
        <script src = "./js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>

        <main class = "main">
            <div class = "main-inner">
                <h1>スタンプ一覧</h1>
                <hr class = "stamp-line">
                <?php
                $stamp_random_id = [];
                $stamp_random_info = [];
                for ($i = 0; $i < count($img_list); $i += 1) {
                    if ($img_list[$i]['stamp_id'] == 'none' && $img_list[$i]['stamp_prob'] == 'none') {
                        echo '<div class = "stamp-list-row">';
                            echo '<p class = "stamp-list-cell-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<button class = "stamp-list-cell-button' . (string)$i . '" type = "button" style = "font-size: 14px; font-weight: bold; color: black; padding: 2px; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray;">詳細</button>';
                        echo '</div>';

                        echo '<div class = "stamp-block' . (string)$i . '" style = "display: none; flex-direction: column; align-items: center;">';
                            echo '<p class = "stamp-block-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            $img_path = './images_stamp/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '.' . $img_list[$i]['img_extention'] . '?version=' . uniqid();
                            echo '<div class = "stamp-block-img-list"><img class = "stamp-block-img" src = "' . $img_path . '"></div>';

                            echo '<button class = "stamp-button-qr' . (string)$i . '" type = "button" style = "display: block; width: 120px; margin-top: 15px; padding: 5px; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; font-weight: bold;">QRコードを表示</button>';

                            echo '<form method = "post" action = "form8.php">';
                                echo '<input type = "text" name = "stamp_table_id" value = "' . $img_list[$i]['table_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "stamp_img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_id" value = "' . $director_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_pass" value = "' . $director_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_name" value = "' . $director_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-edit" type = "submit">編集</button>';
                            echo '</form>';

                            echo '<form method = "post" action = "delete_stamp.php" onSubmit = "return checkSubmit5();">';
                                echo '<input type = "text" name = "stamp_table_id" value = "' . $img_list[$i]['table_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "stamp_img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_id" value = "' . $director_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_pass" value = "' . $director_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_name" value = "' . $director_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-delete" type = "submit">削除</button>';
                            echo '</form>';

                        echo '</div>';

                        echo '<hr class = "stamp-line2">';
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) {
                        $set_img_id = $img_list[$i]['img_id'];
                        $stamp_random_id[] = $set_img_id;

                        for ($j = $i; $j < count($img_list); $j += 1) {
                            if ($set_img_id == $img_list[$j]['img_id']) {
                                $stamp_random_info[] = [$img_list[$j]['table_id'], $img_list[$j]['img_id'], $img_list[$j]['stamp_id'], $img_list[$j]['stamp_prob'], $img_list[$j]['img_extention'], $img_list[$j]['img_title'], $img_list[$j]['date_limit']];
                            }
                        }

                        echo '<div class = "stamp-list-row">';
                            echo '<p class = "stamp-list-cell-title">' . $img_list[$i]['img_title'] . '</p>';
                            echo '<button class = "stamp-list-cell-button' . (string)$i . '" type = "button" style = "font-size: 14px; font-weight: bold; color: black; padding: 2px; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray;">詳細</button>';
                        echo '</div>';

                        echo '<div class = "stamp-block' . (string)$i . '" style = "display: none; flex-direction: column; align-items: center;">';
                            echo '<p class = "stamp-block-limit">有効期限：' . $img_list[$i]['date_limit'] . '</p>';
                            echo '<div class = "stamp-block-img-list-2">';
                                echo '<button class = "stamp-block-left' . (string)$i . '" type = "button" style = "display: block; width: 25px; height: 25px; margin-right: 5px; border: none; border-radius: 50%; background-color: transparent; font-size: 20px; color: gray;">〈</button>';
                                echo '<div class = "stamp-block-img-list' . (string)$i . '" style = "display: flex; align-items: center; margin-top: 20px; width: 200px; overflow: hidden;">';

                                $block_style = ['none', 'none', 'none', 'none', 'none'];

                                foreach ($stamp_random_info as $j => $stamp_data) {
                                    $img_path = './images_stamp/' . $stamp_data[0] . '_' . $stamp_data[1] . '_' . $stamp_data[2] . '.' . $stamp_data[4] . '?version=' . uniqid();
                                    echo '<div class = "stamp-subblock">';
                                        echo '<img class = "stamp-block-img" src = "' . $img_path . '">';
                                        echo '<p class = "stamp-block-prob">確率：' . $stamp_data[3] . '</p>';
                                    echo '</div>';

                                    $block_style[$j] = 'block';
                                }
                                echo '</div>';
                                echo '<button class = "stamp-block-right' . (string)$i . '" type = "button" style = "display: block; width: 25px; height: 25px; margin-left: 5px; border: none; border-radius: 50%; background-color: transparent; font-size: 20px; color: gray;">〉</button>';
                            echo '</div>';

                            echo '<div class = "stamp-random-count' . (string)$i . '" style = "display: flex; align-items: center; margin-top: 15px;">';
                                echo '<button class = "stamp-random-count0-' . (string)$i . '" type = "button" style = "display: ' . $block_style[0] . '; pointer-events: none; width: 25px; height: 6px; margin: 2px; border: none; background-color: lightgray; border-radius: 10px;"></button>';
                                echo '<button class = "stamp-random-count1-' . (string)$i . '" type = "button" style = "display: ' . $block_style[1] . '; pointer-events: none; width: 25px; height: 6px; margin: 2px; border: none; background-color: lightgray; border-radius: 10px;"></button>';
                                echo '<button class = "stamp-random-count2-' . (string)$i . '" type = "button" style = "display: ' . $block_style[2] . '; pointer-events: none; width: 25px; height: 6px; margin: 2px; border: none; background-color: lightgray; border-radius: 10px;"></button>';
                                echo '<button class = "stamp-random-count3-' . (string)$i . '" type = "button" style = "display: ' . $block_style[3] . '; pointer-events: none; width: 25px; height: 6px; margin: 2px; border: none; background-color: lightgray; border-radius: 10px;"></button>';
                                echo '<button class = "stamp-random-count4-' . (string)$i . '" type = "button" style = "display: ' . $block_style[4] . '; pointer-events: none; width: 25px; height: 6px; margin: 2px; border: none; background-color: lightgray; border-radius: 10px;"></button>';
                            echo '</div>';

                            ?>
                            <script>
                                window.addEventListener('load', () => {
                                    const buttonLeft<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-left' . (string)$i . '\''; ?>);
                                    const buttonRight<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-right' . (string)$i . '\''; ?>);
                                    const stampRandonCount<?php echo (string)$i; ?> = [];

                                    if (document.querySelector(<?php echo '\'.stamp-random-count0-' . (string)$i . '\''; ?>).style.display === 'block') {
                                        stampRandonCount<?php echo (string)$i; ?>.push(document.querySelector(<?php echo '\'.stamp-random-count0-' . (string)$i . '\''; ?>));
                                    }
                                    if (document.querySelector(<?php echo '\'.stamp-random-count1-' . (string)$i . '\''; ?>).style.display === 'block') {
                                        stampRandonCount<?php echo (string)$i; ?>.push(document.querySelector(<?php echo '\'.stamp-random-count1-' . (string)$i . '\''; ?>));
                                    }
                                    if (document.querySelector(<?php echo '\'.stamp-random-count2-' . (string)$i . '\''; ?>).style.display === 'block') {
                                        stampRandonCount<?php echo (string)$i; ?>.push(document.querySelector(<?php echo '\'.stamp-random-count2-' . (string)$i . '\''; ?>));
                                    }
                                    if (document.querySelector(<?php echo '\'.stamp-random-count3-' . (string)$i . '\''; ?>).style.display === 'block') {
                                        stampRandonCount<?php echo (string)$i; ?>.push(document.querySelector(<?php echo '\'.stamp-random-count3-' . (string)$i . '\''; ?>));
                                    }
                                    if (document.querySelector(<?php echo '\'.stamp-random-count4-' . (string)$i . '\''; ?>).style.display === 'block') {
                                        stampRandonCount<?php echo (string)$i; ?>.push(document.querySelector(<?php echo '\'.stamp-random-count4-' . (string)$i . '\''; ?>));
                                    }

                                    stampRandonCount<?php echo (string)$i; ?>[0].style.backgroundColor = 'lightskyblue';

                                    buttonLeft<?php echo (string)$i; ?>.addEventListener('click', () => {
                                        for (l = 1; l < stampRandonCount<?php echo (string)$i; ?>.length; l += 1) {
                                            if (stampRandonCount<?php echo (string)$i; ?>[l].style.backgroundColor === 'lightskyblue') {
                                                stampRandonCount<?php echo (string)$i; ?>[l].style.backgroundColor = 'lightgray';
                                                stampRandonCount<?php echo (string)$i; ?>[l - 1].style.backgroundColor = 'lightskyblue';
                                                break;
                                            }
                                        }
                                    });

                                    buttonRight<?php echo (string)$i; ?>.addEventListener('click', () => {
                                        for (l = 0; l < stampRandonCount<?php echo (string)$i; ?>.length - 1; l += 1) {
                                            if (stampRandonCount<?php echo (string)$i; ?>[l].style.backgroundColor === 'lightskyblue') {
                                                stampRandonCount<?php echo (string)$i; ?>[l].style.backgroundColor = 'lightgray';
                                                stampRandonCount<?php echo (string)$i; ?>[l + 1].style.backgroundColor = 'lightskyblue';
                                                break;
                                            }
                                        }
                                    });
                                });
                            </script>
                            <?php

                            $block_style = ['none', 'none', 'none', 'none', 'none'];

                            echo '<button class = "stamp-button-qr' . (string)$i . '" type = "button" style = "display: block; width: 120px; margin-top: 15px; padding: 5px; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; font-weight: bold;">QRコードを表示</button>';

                            echo '<form method = "post" action = "form8.php">';
                                echo '<input type = "text" name = "stamp_table_id" value = "' . $img_list[$i]['table_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "stamp_img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_id" value = "' . $director_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_pass" value = "' . $director_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_name" value = "' . $director_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-edit" type = "submit">編集</button>';
                            echo '</form>';

                            echo '<form method = "post" action = "delete_stamp.php" onSubmit = "return checkSubmit5();">';
                                echo '<input type = "text" name = "stamp_table_id" value = "' . $img_list[$i]['table_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "stamp_img_id" value = "' . $img_list[$i]['img_id'] . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_id" value = "' . $director_id . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_pass" value = "' . $director_pass . '" style = "display: none;">';
                                echo '<input type = "text" name = "director_name" value = "' . $director_name . '" style = "display: none;">';
                                echo '<button class = "stamp-button-delete" type = "submit">削除</button>';
                            echo '</form>';

                        echo '</div>';

                        echo '<hr class = "stamp-line2">';
                        ?>
                        <script>
                            window.addEventListener('load', () => {
                                const stampPanel<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-img-list' . (string)$i . '\'';?>);
                                const buttonLeft<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-left' . (string)$i . '\''; ?>);
                                const buttonRight<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-right' . (string)$i . '\''; ?>);

                                buttonLeft<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    for (let t = 0; t < 200; t += 1) {
                                        setTimeout(() => { stampPanel<?php echo (string)$i; ?>.scrollBy(-1, 0); }, t);
                                    }
                                });

                                buttonRight<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    for (let t = 0; t < 200; t += 1) {
                                        setTimeout(() => { stampPanel<?php echo (string)$i; ?>.scrollBy(1, 0); }, t);
                                    }
                                });
                            });
                        </script>
                        <?php

                        $stamp_random_info = [];
                    }
                }

                $stamp_random_id = [];

                for ($i = 0; $i < count($img_list); $i += 1) {
                    if ($img_list[$i]['stamp_id'] == 'none' && $img_list[$i]['stamp_prob'] == 'none') {
                        $qr_path = './images_qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';

                        echo '<div class = "stamp-block-qr' . (string)$i . '" style = "display: none; flex-direction: column; align-items: center; position: fixed; top: 150px; left: auto; right: auto; width: 260px; background-color: lightgray; border-radius: 10px; border: none; box-shadow: 3px 3px 5px 1px gray;">';
                            echo '<img class = "stamp-block-qr-img' . (string)$i . '" src = "' . $qr_path . '" style = "display: block; width: 200px; height: 200px; margin-left: auto; margin-right: auto; margin-top: 20px; border-radius: 10px;">';
                            $img_path = "./images_stamp/" . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '.' . $img_list[$i]['img_extention'] . '?version=' . uniqid();
                            echo '<div class = "stamp-block-qr-back"><img class = "stamp-block-qr-back-inner" src = "' . $img_path . '"></div>';
                            echo '<a class = "stamp-block-qr-download' . (string)$i . '" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png" style = "display: none;">QRコードをダウンロード</a>';
                            echo '<button class = "stamp-block-qr-save' . (string)$i . '" type = "button" style = "display: block; width: 100px; margin-top: 20px; margin-left: auto; margin-right: auto; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; padding-top: 5px; padding-bottom: 5px; font-weight: bold;">保存する</button>';
                            echo '<button class = "stamp-block-qr-back' . (string)$i . '" type = "button" style = "display: block; width: 100px; margin-top: 20px; margin-bottom: 20px; margin-left: auto; margin-right: auto; background-color: #ff69b4; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; padding-top: 5px; padding-bottom: 5px; font-weight: bold;">閉じる</button>';
                        echo '</div>';

                        ?>
                        <script>
                            window.addEventListener('load', () => {
                                const buttonOpenQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-button-qr' . (string)$i . '\''; ?>);
                                const infoQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr' . (string)$i . '\''; ?>);
                                const buttonCloseQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-back' . (string)$i . '\''; ?>);
                                const buttonSave<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-save' . (string)$i . '\''; ?>);
                                const buttonDownload<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-download' . (string)$i . '\''; ?>);

                                const options = {
                                    duration: 500,
                                    easing: 'ease',
                                    fill: 'forwards',
                                };

                                const openQr = {
                                    transform: ['rotate3d(0, 1, 0, 180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                                    opacity: [0, 1],
                                };

                                const closeQr = {
                                    transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                                    opacity: [1, 0],
                                };

                                buttonOpenQr<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (infoQr<?php echo (string)$i; ?>.style.display === 'none') {
                                        infoQr<?php echo (string)$i; ?>.style.display = 'flex';
                                        infoQr<?php echo (string)$i; ?>.animate(openQr, options);
                                    }
                                });

                                buttonCloseQr<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (infoQr<?php echo (string)$i; ?>.style.display === 'flex') {
                                        const setClose = () => {
                                            infoQr<?php echo (string)$i; ?>.style.display = 'none';
                                        }
                                        setTimeout(setClose, 500);
                                        infoQr<?php echo (string)$i; ?>.animate(closeQr, options);
                                    }
                                });

                                buttonSave<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    buttonDownload<?php echo (string)$i; ?>.click();
                                });
                            });
                        </script>

                        <script>
                            window.addEventListener('load', () => {
                                const buttonDetail<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-list-cell-button' . (string)$i . '\''; ?>);
                                const stampBlock<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block' . (string)$i . '\''; ?>);

                                const options = {
                                    duration: 500,
                                    easing: 'ease',
                                    fill: 'forwards',
                                };

                                const openDetail = {
                                    height: ['0px', '405px'],
                                    opacity: [0, 1],
                                };

                                const closeDetail = {
                                    height: ['405px', '0px'],
                                    opacity: [1, 0],
                                };

                                buttonDetail<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (stampBlock<?php echo (string)$i; ?>.style.display === 'none') {
                                        stampBlock<?php echo (string)$i; ?>.style.display = 'flex';
                                        stampBlock<?php echo (string)$i; ?>.animate(openDetail, options);
                                    } else {
                                        setTimeout(() => { stampBlock<?php echo (string)$i; ?>.style.display = 'none'; }, 500);
                                        stampBlock<?php echo (string)$i; ?>.animate(closeDetail, options);
                                    }
                                });
                            });
                        </script>

                        <?php
                    } else if (in_array($img_list[$i]['img_id'], $stamp_random_id) == false) {
                        $stamp_random_id[] = $img_list[$i]['img_id'];
                        $qr_path = './images_qr/' . $img_list[$i]['table_id'] . '_' . $img_list[$i]['img_id'] . '_qr.png';

                        echo '<div class = "stamp-block-qr' . (string)$i . '" style = "display: none; flex-direction: column; align-items: center; position: fixed; top: 150px; left: auto; right: auto; width: 260px; background-color: lightgray; border-radius: 10px; border: none; box-shadow: 3px 3px 5px 1px gray;">';
                            echo '<img class = "stamp-block-qr-img' . (string)$i . '" src = "' . $qr_path . '" style = "display: block; width: 200px; height: 200px; margin-left: auto; margin-right: auto; margin-top: 20px; border-radius: 10px;">';
                            echo '<div class = "stamp-block-qr-back"><img class = "stamp-block-qr-back-inner" src = "./images/qr-back.png"></div>';
                            echo '<a class = "stamp-block-qr-download' . (string)$i . '" href = "' . $qr_path . '" download = "qr_' . $img_list[$i]['table_id'] . $img_list[$i]['img_id'] . '.png" style = "display: none;">QRコードをダウンロード</a>';
                            echo '<button class = "stamp-block-qr-save' . (string)$i . '" type = "button" style = "display: block; width: 100px; margin-top: 20px; margin-left: auto; margin-right: auto; background-color: lightskyblue; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; padding-top: 5px; padding-bottom: 5px; font-weight: bold;">保存する</button>';
                            echo '<button class = "stamp-block-qr-back' . (string)$i . '" type = "button" style = "display: block; width: 100px; margin-top: 20px; margin-bottom: 20px; margin-left: auto; margin-right: auto; background-color: #ff69b4; border-radius: 10px; border-color: black; box-shadow: 3px 3px 5px 1px gray; color: black; padding-top: 5px; padding-bottom: 5px; font-weight: bold;">閉じる</button>';
                        echo '</div>';

                        ?>
                        <script>
                            window.addEventListener('load', () => {
                                const buttonOpenQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-button-qr' . (string)$i . '\''; ?>);
                                const infoQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr' . (string)$i . '\''; ?>);
                                const buttonCloseQr<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-back' . (string)$i . '\''; ?>);
                                const buttonSave<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-save' . (string)$i . '\''; ?>);
                                const buttonDownload<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block-qr-download' . (string)$i . '\''; ?>);

                                const options = {
                                    duration: 500,
                                    easing: 'ease',
                                    fill: 'forwards',
                                };

                                const openQr = {
                                    transform: ['rotate3d(0, 1, 0, 180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                                    opacity: [0, 1],
                                };

                                const closeQr = {
                                    transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
                                    opacity: [1, 0],
                                };

                                buttonOpenQr<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (infoQr<?php echo (string)$i; ?>.style.display === 'none') {
                                        infoQr<?php echo (string)$i; ?>.style.display = 'flex';
                                        infoQr<?php echo (string)$i; ?>.animate(openQr, options);
                                    }
                                });

                                buttonCloseQr<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (infoQr<?php echo (string)$i; ?>.style.display === 'flex') {
                                        const setClose = () => {
                                            infoQr<?php echo (string)$i; ?>.style.display = 'none';
                                        }
                                        setTimeout(setClose, 500);
                                        infoQr<?php echo (string)$i; ?>.animate(closeQr, options);
                                    }
                                });

                                buttonSave<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    buttonDownload<?php echo (string)$i; ?>.click();
                                });
                            });
                        </script>

                        <script>
                            window.addEventListener('load', () => {
                                const buttonDetail<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-list-cell-button' . (string)$i . '\''; ?>);
                                const stampBlock<?php echo (string)$i; ?> = document.querySelector(<?php echo '\'.stamp-block' . (string)$i . '\''; ?>);

                                const options = {
                                    duration: 500,
                                    easing: 'ease',
                                    fill: 'forwards',
                                };

                                const openDetail = {
                                    height: ['0px', '455px'],
                                    opacity: [0, 1],
                                };

                                const closeDetail = {
                                    height: ['455px', '0px'],
                                    opacity: [1, 0],
                                };

                                buttonDetail<?php echo (string)$i; ?>.addEventListener('click', () => {
                                    if (stampBlock<?php echo (string)$i; ?>.style.display === 'none') {
                                        stampBlock<?php echo (string)$i; ?>.style.display = 'flex';
                                        stampBlock<?php echo (string)$i; ?>.animate(openDetail, options);
                                    } else {
                                        setTimeout(() => { stampBlock<?php echo (string)$i; ?>.style.display = 'none'; }, 500);
                                        stampBlock<?php echo (string)$i; ?>.animate(closeDetail, options);
                                    }
                                });
                            });
                        </script>

                        <?php
                    }
                }
                ?>
            </div>
        </main>

        <footer class = "footer">
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
