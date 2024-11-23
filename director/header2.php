<div class = "header-inner">
    <form method = "post" action = "index_director.php">
        <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
        <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
        <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
        <button class = "header-logo" type = "submit">
            <img src = "./images/logo-1.png" alt = "ロゴ画像">
        </button>
    </form>
</div>

<div class = "main-banner">
    <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
</div>