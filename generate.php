<?php
include('./source.php');
include('./parser/parse-activator/autoload.php'); // 構文解析器のセットアップ

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $dbh = null;

    // 英文解析
    $text_input = $_POST['text_input']; // POSTから受け取る
    $text_list = preg_split('/\r\n|\r|\n/', $text_input); // 改行で分割し配列に格納
    $parse_results = $parser->parseSentences($text_list); // 解析を実行
    $results = []; // 解析結果の文字列を格納する配列
    for ($i = 0; $i < count($parse_results); $i++) { // 解析結果の格納
        for ($j = 0; $j < count($parse_results[$i]["penn"]["children"]); $j++) {
            $results[$i] = setTree($parse_results[$i]["penn"]["children"][$j]); // 結果を格納
        }
    }
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>構文解析</title>
        <meta name = "description" content = "構文解析結果">
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
            <?php include('./header.php'); ?>
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

                <!-- 英文解析 結果 -->
                <?php foreach ($results as $i => $r) { ?>
                    <div>
                        <p><?php echo $text_list[$i] ?></p>
                        <p><?php echo $r ?></p>
                    </div>
                    <br>
                <?php } ?>

            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
