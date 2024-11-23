<div class = "header-inner">
    <form method = "post" action = "index.php">
        <?php
        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
        ?>
        <button class = "header-logo" type = "submit">
            <img src = "./images/logo-1.png" alt = "ロゴ画像">
        </button>
    </form>
    <button class = "header-menu-button">
        <img src = "./images/menu.png" alt = "メニューボタン">
    </button>
    <p class = "header-menu-info" style = "display: none;">closed</p>
    <div class = "header-site-menu">
        <ul>
            <li>
                <?php
                echo $user_name;
                ?>
            </li>
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
        </ul>
    </div>
</div>
<div class = "main-banner">
    <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
</div>