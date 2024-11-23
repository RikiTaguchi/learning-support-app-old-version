<div class = "footer-inner">
    <form method = "post" action = "index.php">
        <div class = "footer-logo">
            <?php
            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
            ?>
            <button class = "footer-logo" type = "submit">
                <img src = "./images/logo-3.png" alt = "ロゴ画像">
            </button>
        </div>
    </form>
    <div class = "footer-site-menu">
        <ul>
            <li><?php make_link('ホーム', 'index.php', [$user_name, $login_id, $user_pass]) ?></li>
            <li><?php make_link('テスト作成', 'form.php', [$user_name, $login_id, $user_pass]) ?></li>
            <li><?php make_link('暗記トレーニング', 'form2.php', [$user_name, $login_id, $user_pass]) ?></li>
            <li><?php make_link('計算トレーニング', 'form10.php', [$user_name, $login_id, $user_pass]) ?></li>
            <?php
            if ($login_id != '000000') {
                echo '<li>';
                make_link('復習モード', 'form3.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
                echo '<li>';
                make_link('My単語帳作成', 'form4.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
                echo '<li>';
                make_link('英文解析', 'form5.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
                echo '<li>';
                make_link('英作文添削', 'form6.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
                echo '<li>';
                make_link('スタンプカード', 'detail_stamp.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
                echo '<li>';
                make_link('アカウント情報', 'info_account.php', [$user_name, $login_id, $user_pass]);
                echo '</li>';
            }
            ?>
            <li><?php make_link('ログアウト', 'error.php?type=6', ['', '', '']) ?></li>
            <p class = "footer-copyright">&copy;Wordsystem</p>
        </ul>
    </div>
</div>