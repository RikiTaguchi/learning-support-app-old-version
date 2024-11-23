<?php
include('./source.php');

$text = $_POST['text'];

$text = str_replace(array("\r\n", "\r", "\n"), "\n", $text);
$text_list = explode("\n", $text);
$info_text = [];

function make_text($text_input, $api_key) {
    $api_url = "https://api.openai.com/v1/chat/completions";

    $api_headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
    );

    $api_data = array(
        'model' => 'gpt-4',
        'messages' => [
            ["role" => "system", "content" => "日本語に翻訳してください。"],
            ['role' => 'user', 'content' => $text_input],
        ],
        'max_tokens' => 500,
    );
        
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $api_url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_data)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $api_headers); 
        
    $response = curl_exec($ch); 
    curl_close($ch); 
    
    $result = json_decode($response, true);
    $result_message = $result["choices"][0]["message"]["content"];

    return $result_message;
}

function make_structure($text_input, $api_key) {
    $api_url = "https://api.openai.com/v1/chat/completions";

    $api_headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
    );

    $api_data = array(
        'model' => 'gpt-4',
        'messages' => [
            ["role" => "system", "content" => "入力された英文を、以下の規則で解析し、その結果を出力例に倣って出力してください。主語：S, 動詞：V, 目的語：O, 補語：C, 形容詞・形容詞句・形容詞節：(), 副詞・副詞句・副詞節：[]\n\n出力例１\n<S The man (standing [under the tree])> <V is> <C my son>.\n出力例２\n<S He> <V likes> <O playing basketball> [so much] and <V practices> <O it> [every weekend] [with his teammates]."],
            ['role' => 'user', 'content' => $text_input],
        ],
        'max_tokens' => 500,
    );
        
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $api_url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_data)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $api_headers); 
        
    $response = curl_exec($ch); 
    curl_close($ch); 
    
    $result = json_decode($response, true);

    $result_message = str_replace('<', '{', $result["choices"][0]["message"]["content"]);
    $result_message = str_replace('>', '}', $result_message);

    return $result_message;
}

function make_img($text_input, $api_key) {
    $api_url = 'https://api.openai.com/v1/images/generations';
    $prompt = 'A cartoon of ' . $text_input;
    
    $api_headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    );

    $api_data = array(
        'model' => 'dall-e-3',
        'prompt' => $prompt,
        'size' => '1024x1024',
        'quality' => 'standard',
        'n' => 1,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $api_headers);

    $response = curl_exec($ch);

    if ($response === false) {
        die(curl_error($ch));
    }
    $result = json_decode($response, true);
    $result_img = $result["data"][0]["url"];
    
    return $result_img;
}

function edit_text($text_result) {
    $data_result = str_split($text_result);
    if (count($data_result) == 0) {
        return '<font color="red">解析に失敗しました。</font>';
    } else {
        $result = $text_result;
        $result = str_replace('{S', '<font color="black">{S</font>', $result);
        $result = str_replace('{V', '<font color="black">{V</font>', $result);
        $result = str_replace('{O', '<font color="black">{O</font>', $result);
        $result = str_replace('{C', '<font color="black">{C</font>', $result);
        $result = str_replace('{SV', '<font color="black">{SV</font>', $result);
        $result = str_replace('}', '<font color="black">}</font>', $result);
        $result = str_replace('{', '&lt;', $result);
        $result = str_replace('}', '&gt;', $result);
        $result = str_replace('[', '<font color="blue">[</font>', $result);
        $result = str_replace(']', '<font color="blue">]</font>', $result);
        $result = str_replace('(', '<font color="limegreen">(</font>', $result);
        $result = str_replace(')', '<font color="limegreen">)</font>', $result);
        $result = '<font color="red">' . $result . '</font>';
        return $result;
    }
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $my_list_id = $table_id . '_my_book_list';
    if ($_POST['apikey'] == '') {
        $api_key = $result['api_key'];
    } else {
        $api_key = $_POST['apikey'];
    }
    
    if ($login_id != '000000' && $user_pass != '569452' && $user_name != 'ゲスト') {
        $sql = 'SELECT * FROM ' . $my_list_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

foreach ($text_list as $t) {
    if ($t != '') {
        $japanese = make_text($t, $api_key);
        $structure = make_structure($t, $api_key);
        $img = make_img($t, $api_key);

        if ($japanese != '' && $structure != '' && $img != '') {
            $info_text[] = [$japanese, $structure, $img, $t];
        } else {
            header('Location: https://wordsystemforstudents.com/error.php?type=9', true, 307);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>構文解析</title>
        <meta name = "description" content = "構文解析入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/generate.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/toggle-structure.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h1 class = "main-inner-result-title">解析結果</h1>
                <button class = "main-inner-button-howto1">
                    構文規則
                </button>
                <button class = "main-inner-button-howto2">
                    構文規則
                </button>
                <div class = "main-inner-howto">
                    <ul>
                        <li>主語　：S</li>
                        <li>動詞　：V</li>
                        <li>目的語：O</li>
                        <li>補語　：C</li>
                        <li>形容詞：( )</li>
                        <li>副詞　：[ ]</li>
                    </ul>
                </div>
                <hr class = "result_line">
                <?php
                foreach ($info_text as $t) {
                    if ($t != '') {
                        $japanese = $t[0];
                        $structure = $t[1];
                        $img = $t[2];

                        $structure = edit_text($t[1]);

                        if ($japanese != '' && $structure != '' && $img != '') {
                            echo '<p class = "result_english">' . $t[3] . '</p>';
                            echo '<p class = "result_japanese">' . $japanese . '</p>';
                            echo '<p class = "result_structure">' . $structure . '</p>';
                            echo '<img class = "result_img" src = "' . $img . '" alt = "生成画像">';
                            echo '<hr class = "result_line">';
                        }
                    }
                }
                ?>
            </div>
        </main>
        <footer class = "footer">
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>
