<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>管理者ログイン</title>
        <meta name = "description" content = "管理者ログイン">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/login.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/set-cookie.js"></script>
        <script src = "./js/set-banner2.js"></script>
    </head>
    <body>
        <header class = "header">
            <div class = "header-inner">
                <a class = "header-logo" href = "./login_director.php">
                    <img src = "../images/logo-1.png" alt = "ロゴ画像">
                </a>
            </div>
            <div class = "main-banner"><p class = "main-banner-text"></p></div>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h3 class = "main-login-title">管理者ログイン</h3>
                <form method = "post" action = "login_director_check.php">
                    <p>管理者ID</p>
                    <input class = "main-form-info main-form-info-login" type = "text" name = "director_id" required>
                    <p>パスワード</p>
                    <input class = "main-form-info main-form-info-pass" type = "text" name = "director_pass" required>
                    <div class = "main-form-login"><input class = "main-login-button" type = "submit" name = "submit" value = "ログイン"></div>
                </form>
                <button class = "main-button-new">
                    <a class = "main-button-new-link" href = "make_director.php">新規登録</a>
                </button>
            </div>
        </main>
        <footer class = "footer">
            <div class = "footer-inner">
                <div class = "footer-logo">
                    <a href = "./login_director.php">
                        <img src = "../images/logo-3.png" alt = "ロゴ画像">
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
