<div class="row">
    <div class="col-sm-4">
        <!-- The release details will open in a modal window -->
        <a href="#release-modal<?php echo $release['id']; ?>" data-toggle="modal" data-target="#release-modal<?php echo $release['id']; ?>">
            <img src="static/img/site/cd.jpg" alt="CD placeholder" /><br />
        </a>
        <h3><?php echo $release['title']; ?> <small>by <?php echo $release['artist']; ?></small></h3>
        <p><?php echo $release['release_date']; ?></p>
        <?php
            if (strtolower($release['has_cd']) == 'yes') {
                echo '<small>CD available</small>';
            }
        ?>
        <small>Code: <?php echo $release['release_code']; ?></small>
    </div>
    <div class="col-sm-4">
        <?php
            foreach ($songs as $song) {
                echo $song["title"];
                echo ' (';
                echo $song["duration"];
                echo ')<br />';
            }
        ?>
    </div>
    <div class="col-sm-4">
        Recored and produced
    </div>
</div>
<hr />

<!-- Modal contents -->
<div class="modal fade" id="release-modal<?php echo $release['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $release['title'].' - '.$release['release_date']; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <img src="static/img/site/cd.jpg" alt="CD placeholder" />
                        <p><?php echo $release['title']; ?></p>
                    </div>
                    <div class="row">
                        <section class="well">
                            <?php
                                $api = 'api/v1/releases/'.$release['id'].'/comments';
                                $release_comments = file_get_contents(SERVER_URL.$api);
                                $release_comments = json_decode($release_comments, true);
                                foreach ($release_comments as $comment) {
                                    echo '<strong>'.$comment['author'].'</strong>: '.$comment['comment'];
                                    echo '<br />';
                                }
                            ?>
                        </section>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
