<div class="row">
    <div class="col-sm-6"><?php echo $release["title"]; ?></div>
    <div class="col-sm-6">
        <?php
            foreach($songs as $song) {
                echo $song["title"];
                echo " (";
                echo $song["duration"];
                echo ")<br />";
            }
        ?>
    </div>
</div>