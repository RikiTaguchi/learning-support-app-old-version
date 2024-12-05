<div class = "footer-inner">
    <form method = "post" action = "index_director.php">
        <div class = "footer-logo">
            <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
            <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
            <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
            <button class = "footer-logo" type = "submit">
                <img src = "../images/logo-3.png" alt = "ロゴ画像">
            </button>
        </div>
        <div class = "footer-site-menu">
            <ul>
                <p class = "footer-copyright">&copy;Wordsystem</p>
            </ul>
        </div>
    </form>
</div>
