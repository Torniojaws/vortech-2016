<div class="row">
    <div class="col-sm-3">
        <a href="<?php echo $video['url']; ?>">
            <?php
                if (file_exists('static/img/'.$video['thumbnail']) == false) {
                    $video['thumbnail'] = 'videos/thumbnails/video.png';
                }
             ?>
            <img src="static/img/<?php echo $video['thumbnail']; ?>" alt="<?php echo $video['title']; ?>" />
        </a>
    </div>
    <div class="col-sm-9">
        <h2 id="videotitle-<?php echo $video['id']; ?>"<?php
            if ($_SESSION['authorized'] == 1) {
                echo ' class="edit-video"';
            }
         ?>><?php echo $video['title']; ?></h2>
        <aside>
            <small>
                <?php
                    echo $video['name'];
                    echo ' &ndash; ';
                    if ($_SESSION['authorized'] == 1) {
                        echo '<span id="videodura-'.$video['id'].'"';
                        echo ' class="edit-video';
                        echo '">';
                    }
                    echo $video['duration'];
                    if ($_SESSION['authorized'] == 1) {
                        echo '</span>';
                    }
                    echo '<br />';
                    echo 'At <strong>'.$video['host'].'</strong>';
                ?>
            </small>
        </aside>
    </div>
</div>
<hr />
