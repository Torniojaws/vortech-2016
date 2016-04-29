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
                        <img src="<?php
                                    if (file_exists($release['thumbnail'])) {
                                        echo $release['thumbnail'];
                                    } else {
                                        echo 'static/img/site/cd.jpg';
                                    } ?>" alt="<?php echo $release['title']; ?>" />
                        <p><?php echo $release['title']; ?></p>
                    </div>
                    <div class="row">
                        <section class="well">
                            <?php
                                $api = 'api/v1/releases/'.$release['release_code'].'/comments';
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
