<?php
// 既存Book情報
$book_count_list = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$book_id_list = ['target_1400', 'target_1900', 'system_English', 'rapid_Reading', 'Vintage', 'pass_3', 'pass_pre2', 'pass_2', 'pass_pre1', 'pass_1', 'get_Through_2600', 'meiko_original_1', 'meiko_original_2', 'gold_phrase', 'kobun300', 'kobun315', 'kobun330'];
$book_name_list = ['ターゲット1400', 'ターゲット1900', 'システム英単語', '速読英熟語(熟語)', 'Vintage', 'パス単(３級)', 'パス単(準２級)', 'パス単(２級)', 'パス単(準１級)', 'パス単(１級)', 'ゲットスルー2600', '明光暗記テキスト(単語)', '明光暗記テキスト(文法)', 'TOEIC金のフレーズ', 'みるみる古文単語300', '古文単語315', '古文単語330'];
$default_count = count($book_id_list);

// 入力範囲のエラーをチェックする関数
function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0) == false) {
        return 2;
    } else {
        return 3;
    }
}

// 既存Bookのoptionタグを生成する関数
function set_options() {
    global $book_name_list;
    global $default_count;
    echo '<option value = "n" hidden>選択してください</option>' . PHP_EOL;
    for ($i = 0; $i < $default_count; $i++) {
        echo '<option value = "' . (string)($i + 1) . '">' . $book_name_list[$i] . '</option>' . PHP_EOL;
    }
}

