<?php
include('./source.php');

$question = $_POST['question'];
$count = (string)$_POST['count'];
$answer = $_POST['answer'];

function check_answer($text_question, $text_count, $text_answer, $api_key) {
    $direction = file_get_contents('./text/writing_direction.txt');
    $user_input = '問題: ' . $text_question . "\n\n" . '指定単語数: ' . $text_count . "\n\n" . '解答: ' . $text_answer;

    $api_url = "https://api.openai.com/v1/chat/completions";

    $api_headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
    );

    $api_data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ["role" => "system", "content" => $direction],
            ['role' => 'user', 'content' => $user_input],
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
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>英作文添削</title>
        <meta name = "description" content = "英作文添削">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/writing.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h1 class = "main-inner-result-title">添削結果</h1>
                <hr class = "result_line">
                
                <div class = "main-innder-result-check">
                    <?php
                    $result_writing = check_answer($question, $count, $answer, $api_key);
                    $result_writing = preg_replace('/文法的な誤り/', '<span class = "result-subtitle">文法的な誤り</span>', $result_writing, 1);
                    $result_writing = preg_replace('/単語数/', '<span class = "result-subtitle">単語数</span>', $result_writing, 1);
                    $result_writing = preg_replace('/内容・表現/', '<span class = "result-subtitle">内容・表現</span>', $result_writing, 1);
                    $result_writing = preg_replace('/修正案/', '<span class = "result-subtitle">修正案</span>', $result_writing, 1);
                    echo nl2br($result_writing);
                    ?>
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
