<div class="row">
    <div class="col-sm-3">
        <a href="static/img/<?php echo strtolower($shop['name_id']) . "/"; echo $shop['full']; ?>">
            <img src="static/img/<?php
                    $image = strtolower($shop['name_id']) . "/" . $shop['thumbnail'];
                    if(file_exists('static/img/' . $image)) {
                        echo $image;
                    } else {
                        echo 'no-photo.jpg';
                    }
                ?>" alt="<?php echo $shop['name']; ?>" />
        </a>
    </div>
    <div class="col-sm-9">
        <h2><?php echo $shop['name']; ?></h2>
        <p><?php echo $shop['description']; ?></p>
        <aside>
            <small>
                Price: <span class="label label-primary label-pill pull-xs-right"><?php echo $shop['price']; ?></span>
            </small>
        </aside>
        <br />
        <section class="shops">
            Get it from:
            <?php
                if(isset($shop['paypal_link'])) {
                    echo '<a href="'.$shop['paypal_link'].'"
                          <span class="label label-info label-pill pull-xs-right">PayPal</span></a> ';
                }
                if(isset($shop['bandcamp_link'])) {
                    echo '<a href="'.$shop['bandcamp_link'].'"
                          <span class="label label-info label-pill pull-xs-right">BandCamp</span></a> ';
                }
                if(isset($shop['amazon_link'])) {
                    echo '<a href="'.$shop['amazon_link'].'"
                          <span class="label label-info label-pill pull-xs-right">Amazon</span></a> ';
                }
                if(isset($shop['spotify_link'])) {
                    echo '<a href="'.$shop['spotify_link'].'"
                          <span class="label label-info label-pill pull-xs-right">Spotify</span></a> ';
                }
                if(isset($shop['deezer_link'])) {
                    echo '<a href="'.$shop['deezer_link'].'"
                          <span class="label label-info label-pill pull-xs-right">Deezer</span></a> ';
                }
                if(isset($shop['itunes_link'])) {
                    echo '<a href="'.$shop['itunes_link'].'"
                          <span class="label label-info label-pill pull-xs-right">iTunes</span></a> ';
                }
            ?>
        </section>
    </div>
</div>
<hr />
