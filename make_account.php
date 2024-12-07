<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "単語システムアカウント作成ページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/make_account.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/set-banner3.js"></script>
    </head>
    <body>
        <header class = "header">
            <div class = "header-inner">
                <a class = "header-logo" href = "./login.php">
                    <img src = "./images/logo-1.png" alt = "ロゴ画像">
                </a>
            </div>
            <div class = "main-banner"><p class = "main-banner-text"></p></div>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">アカウント情報</p>
                <form method = "post" action = "make_account_check.php">
                    <p>ユーザーネーム</p>
                    <input class = "main-form-input" type = "text" name = "user_name" required>
                    <p>ユーザーID</p>
                    <input class = "main-form-input" type = "text" name = "login_id" required>
                    <p>パスワード</p>
                    <input class = "main-form-input" type = "text" name = "user_pass" required>
                    <input class = "info-banner" type = "text" name = "info_banner" value = "new-account" style = "display: none;">
                    <div class = "main-form-make"><input class = "main-make-button" type = "submit" name = "submit" value = "登録"></div>
                </form>
                <p class = "main-back">
                    <a href = "login.php">ログイン画面へ戻る</a>
                </p>
            </div>
        </main>
        <footer class = "footer">
            <div class = "footer-inner">
                <div class = "footer-logo">
                    <a href = "./login.php">
                        <img src = "./images/logo-3.png" alt = "ロゴ画像">
                    </a>
                </div>
                <div class = "footer-site-menu">
                    <ul>
                        <p class = "footer-copyright">&copy;Wordsystem</p>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>
