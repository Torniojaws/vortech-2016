<!-- Modal contents -->
<div class="modal fade" id="photo-modal<?php echo $photo['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $photo['name'].' - '.$photo['date_taken']; ?></h4>
            </div>
            <div class="modal-body text-center">
                <img src="static/img/<?php echo strtolower($photo['name_id']).'/';
                echo $photo['full']; ?>" alt="<?php echo $photo['caption']; ?>" />
                <p><?php echo $photo['caption']; ?></p>
            </div>
            <div class="container-fluid">
                <section class="well">
                    <?php
                        $api = 'api/v1/photos/'.$photo['id'].'/comments';
                        $comments = file_get_contents(SERVER_URL.$api);
                        $comments_list = json_decode($comments, true);
                        $counter = 0;
                            // We'll show all comments here - data loaded near row 10
                            foreach ($comments_list as $comment) {
                                ++$counter;
                                if ($counter % 2 == 0) {
                                    echo '<div class="row alternate-comment-row">';
                                } else {
                                    echo '<div class="row">';
                                } ?>
                            <div class="col-sm-2">
                                <?php echo '<small>'.date('Y-m-d', strtotime($comment['date_commented'])).'</small>'.PHP_EOL;
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                    // Author name from ID:
                                    $author_api = 'api/v1/users/'.$comment['author_id'];
                                    $author = json_decode(file_get_contents(SERVER_URL.$author_api), true);
                                    echo '<strong>'.$author[0]['name'].'</strong>'.PHP_EOL;
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php echo $comment['comment'].PHP_EOL;
                                ?>
                            </div>
                        </div>
                        <?php
                    } ?>
                </section>
            </div>
            <div class="row">
                <?php include 'apps/photos/partials/photo-comments.php'; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
