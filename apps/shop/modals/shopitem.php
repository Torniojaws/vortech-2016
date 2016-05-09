<!-- Modal contents -->
<div class="modal fade" id="shopitem-modal<?php echo $shop['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $shop['name']; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <img src="<?php
                                    if (file_exists($shop['thumbnail'])) {
                                        echo $shop['thumbnail'];
                                    } else {
                                        echo 'static/img/site/cd.jpg';
                                    } ?>" alt="<?php echo $shop['name']; ?>" />
                        <p><?php echo $shop['name']; ?></p>
                    </div>
                    <div class="row">
                        <section class="well">
                            <?php
                                $api = 'api/v1/shop/'.$shop['id'].'/comments';
                                $comments = file_get_contents(SERVER_URL.$api);
                                $comments_list = json_decode($comments, true);
                                foreach ($comments_list as $comment) {
                                    echo '<strong>'.$comment['author'].'</strong>: '.$comment['comment'];
                                    echo '<br />';
                                }
                            ?>
                        </section>
                    </div>
                </div>
                <!-- Comments -->
                <div class="row">
                    <?php include 'apps/shop/partials/shop-comments.php'; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
