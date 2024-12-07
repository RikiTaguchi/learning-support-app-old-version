<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>単語システム</title>
        <meta name = "description" content = "単語システムログインページ">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/login.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/set-banner2.js"></script>
        <script src = "./js/set-cookie.js"></script>
        <script src = "./js/change-form.js"></script>
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
                <h3 class = "main-login-title">ログイン</h3>
                <form class = "main-login-form-area" method = "post" action = "login_check.php">
                    <p>ユーザーID</p>
                    <input class = "main-form-info main-form-info-login" type = "text" name = "login_id" required>
                    <p>パスワード</p>
                    <input class = "main-form-info main-form-info-pass" type = "text" name = "user_pass" required>
                    <input class = "info-banner" type = "text" name = "info_banner" value = "login" style = "display: none;">
                    <div class = "main-form-login"><input class = "main-login-button" type = "submit" name = "submit" value = "ログイン"></div>
                </form>
                <button class = "main-button-new">
                    <a class = "main-button-new-link" href = "make_account.php">新規登録</a>
                </button>
                <form method = "post" action = "index.php">
                    <input class = "info-guest" type = "text" name = "login_id" value = "000000">
                    <input class = "info-guest" type = "text" name = "user_pass" value = "569452">
                    <input class = "info-guest" type = "text" name = "user_name" value = "ゲスト">
                    <button class = "main-login-guest-p" ><input class = "main-login-guest" type = "submit" name = "submit" value = "ゲストモード"></button>
                </form>
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
