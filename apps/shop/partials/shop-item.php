<div class="row">
    <div class="col-sm-3">
        <a href="static/img/<?php echo strtolower($shop['name_id']).'/'; echo $shop['full']; ?>">
            <img src="static/img/<?php
                    $image = strtolower($shop['name_id']).'/'.$shop['thumbnail'];
                    if (file_exists('static/img/'.$image)) {
                        echo $image;
                    } else {
                        echo 'no-photo.jpg';
                    }
                ?>" alt="<?php echo $shop['name']; ?>" />
        </a>
    </div>
    <div class="col-sm-9">
        <h2 id="shopname-<?php echo $shop['id']; ?>"
            <?php if($_SESSION['authorized'] == 1) { echo ' class="edit-shop"'; } ?>><?php
            echo $shop['name']; ?></h2>
        <p id="shopdesc-<?php echo $shop['id']; ?>"
            <?php if($_SESSION['authorized'] == 1) { echo ' class="edit-shop"'; } ?>><?php
            echo $shop['description']; ?></p>
        <aside>
            <small>
                Price:
                <?php
                    require_once $root.'classes/CurrencyConverter.php';
                    $convert = new CurrencyConverter();
                    $usd = $convert->euroTo('USD', (float) $shop['price']);
                ?>
                <?php
                    if($_SESSION['authorized'] == 1) {
                        echo '<span id="shopprice-'.$shop['id'].'" class="edit-shop">';
                    } else {
                        echo '<span class="label label-primary label-pill pull-xs-right">';
                    }
                    echo $shop['price'];
                    echo '</span>';
                ?>
                EUR
                &nbsp;&dash; Current exchange rate (ECB):
                <span class="label label-primary label-pill pull-xs-right">
                    <?php echo $usd; ?> USD
                </span>
            </small>
        </aside>
        <br />
        <section class="shops">
            Get it from:
            <?php
                if (strlen($shop['paypal_link']) > 0) {
                    echo '<a href="'.$shop['paypal_link'].'">
                          <span class="label label-info label-pill pull-xs-right">PayPal</span></a> ';
                }
                if (strlen($shop['bandcamp_link']) > 0) {
                    echo '<a href="'.$shop['bandcamp_link'].'">
                          <span class="label label-info label-pill pull-xs-right">BandCamp</span></a> ';
                }
                if (strlen($shop['amazon_link']) > 0) {
                    echo '<a href="'.$shop['amazon_link'].'">
                          <span class="label label-info label-pill pull-xs-right">Amazon</span></a> ';
                }
                if (strlen($shop['spotify_link']) > 0) {
                    echo '<a href="'.$shop['spotify_link'].'">
                          <span class="label label-info label-pill pull-xs-right">Spotify</span></a> ';
                }
                if (strlen($shop['deezer_link']) > 0) {
                    echo '<a href="'.$shop['deezer_link'].'">
                          <span class="label label-info label-pill pull-xs-right">Deezer</span></a> ';
                }
                if (strlen($shop['itunes_link']) > 0) {
                    echo '<a href="'.$shop['itunes_link'].'">
                          <span class="label label-info label-pill pull-xs-right">iTunes</span></a> ';
                }
            ?>
        </section>
    </div>
</div>
<hr />
