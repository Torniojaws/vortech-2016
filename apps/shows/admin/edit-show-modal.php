<div class="row">
    <label for="news-btn">Admin - Edit show</label><br />
    <button type="button" class="btn btn-primary" id="edit-show-btn" data-toggle="modal" data-target="#edit-show<?php echo $show['id']; ?>-form">Open Form</button>
</div>

<!-- Modal for show details -->
<div class="modal fade" id="edit-show<?php echo $show['id']; ?>-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit show</h4>
            </div>
            <div class="modal-body">
                <!-- Edit show -->
                <form class="form" id="ad-edit-show-form" name="add-edit-show-form">

                    <div class="form-group">
                        <!-- id -->
                        <p>Show ID: <b><?php echo $show['id']; ?></b></p>
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $show['id']; ?>" />

                        <!-- date -->
                        <label for="date">Show date</label>
                        <input type="text" class="form-control" id="date" name="date" value="<?php echo $show['show_date']; ?>" />

                        <!-- continent -->
                        <label for="continent">Show continent</label>
                        <input type="text" class="form-control" id="continent" name="continent" value="<?php echo $show['continent']; ?>" />

                        <!-- country -->
                        <label for="country">Show country</label>
                        <input type="text" class="form-control" id="country" name="country" value="<?php echo $show['country']; ?>" />

                        <!-- city -->
                        <label for="city">Show city</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $show['city']; ?>" />

                        <!-- venue -->
                        <label for="venue">Show venue</label>
                        <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $show['venue']; ?>" />

                        <!-- other bands -->
                        <label for="bands">Show other bands</label>
                        <input type="text" class="form-control" id="bands" name="bands" value="<?php echo $show['other_bands']; ?>" />

                        <!-- band comments -->
                        <label for="band-comments">Show band comments</label>
                        <input type="text" class="form-control" id="band-comments" name="band-comments" value="<?php echo $show['band_comments']; ?>" />

                        <!-- setlist -->
                        <label for="setlist">Show setlist</label>
                        <textarea class="form-control" rows="5" id="setlist" name="setlist"><?php echo $show['setlist']; ?></textarea>

                        <!-- performers -->
                        <label for="date">Show performers</label>
                        <textarea class="form-control" rows="5" id="performers" name="performers"><?php echo $show['performers']; ?></textarea>

                    </div>

                    <button type="submit" class="btn btn-primary" name="Submit" id="send-edit-show-form">Submit the edit</button>
                </form>
                <div id="added-ok" class="text-success" hidden><h3>Successfully edited show! Boom...</h3></div>
                <div id="add-failed" class="text-danger" hidden><h3>Failed to edit show!</h3></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
