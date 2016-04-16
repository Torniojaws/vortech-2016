<div class="row text-right">
    <label for="news-btn">Admin - Add comment</label><br />
    <button type="button" class="btn btn-primary" id="guestbook-comment-btn" data-toggle="modal"
            data-target="#guestbook-comment-form<?php echo $guest['id']; ?>">Open Form</button>
</div>

<!-- Modal for guestbook comment details -->
<div class="modal fade" id="guestbook-comment-form<?php echo $guest['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add comment</h4>
            </div>
            <div class="modal-body">
                <!-- Original message -->
                <blockquote>
                    <p><?php echo $guest['post']; ?></p>
                    <small><?php echo $guest['name']; ?></small>
                </blockquote>

                <!-- Add guestbook comment -->
                <form role="form" class="form" id="ad-guestbook-comment-form" name="add-guestbook-comment-form">

                    <div class="form-group">
                        <label for="text">Your comment</label>
                        <textarea class="form-control" rows="5" id="text" name="text" placeholder="Write your comment here"></textarea>
                        <input type="text" name="original_id" value="<?php echo $guest['id']; ?>" hidden />
                    </div>

                    <button type="submit" class="btn btn-primary" name="Submit" id="send-guestbook-comment-form">Add the comment</button>
                </form>
                <div id="added-ok" class="text-success" hidden><h3>Successfully added comment! Boom...</h3></div>
                <div id="add-failed" class="text-danger" hidden><h3>Failed to add comment!</h3></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
