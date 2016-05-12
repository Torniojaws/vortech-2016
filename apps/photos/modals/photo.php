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
            <div class="photo-rating text-center">
                <!-- Star rating for the Photo -->
                <?php
                    $votes_api = 'api/v1/votes/photos/'.$photo['id'];
                    $votes = json_decode(file_get_contents(SERVER_URL.$votes_api), true);
                    $photo_rating = $votes[0]['rating'];
                    $max_rating = $votes[0]['max_rating'];
                    $vote_count = $votes[0]['votes'];
                ?>
                <input id="photo-rating-<?php echo $photo['id']; ?>" type="number" class="rating"
                       value=<?php echo $photo_rating; ?> min=0 max=<?php echo $max_rating; ?>
                       data-step=0.5 data-size="xs" data-rtl="false" />
                <small>
                    <?php
                        echo $vote_count;
                        // Oxford comma of CS?
                        if ($vote_count == 1) {
                            echo ' vote';
                        } else {
                            echo ' votes';
                        }
                    ?>
                </small>
                <div id="added-ok-<?php echo $photo['id']; ?>" class="text-success" hidden><h3>Thanks for your vote!</h3></div>
            </div>
            <div class="container-fluid">
                <div class="well">
                    <?php
                        $api = 'api/v1/photos/'.$photo['id'].'/comments';
                        $comments = file_get_contents(SERVER_URL.$api);
                        $comments_list = json_decode($comments, true);
                        $modal_counter = 0;

                        $skip = empty($comments_list[0]);

                        foreach ($comments_list as $comment) {
                            ++$modal_counter;
                            if ($modal_counter % 2 == 0) {
                                echo '<div class="row alternate-comment-row">';
                            } else {
                                echo '<div class="row">';
                            } ?>
                            <div class="col-sm-2">
                                <?php
                                    if ($skip == false) {
                                        echo '<small>'.date('Y-m-d', strtotime($comment['date_commented'])).'</small>'.PHP_EOL;
                                    }
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                    if ($skip == false) {
                                        // Author name from ID:
                                        $author_api = 'api/v1/users/'.$comment['author_id'];
                                        $author = json_decode(file_get_contents(SERVER_URL.$author_api), true);
                                        echo '<strong>'.$author[0]['name'].'</strong>'.PHP_EOL;
                                    }
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php echo $comment['comment'].PHP_EOL;
                                ?>
                            </div>
                        </div>
                        <?php
                        } // Foreach ?>
                </div>
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
