<div class="container-fluid">
    <div class="row text-center">
        <label for="release-btn">Admin - Add new release</label><br />
        <button type="button" class="btn btn-primary" id="release-btn" data-toggle="modal" data-target="#release-form">Open Form</button>
    </div>

    <!-- Modal for release details -->
    <div class="modal fade" id="release-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new release</h4>
                </div>
                <div class="modal-body text-center">
                    <!-- Add new release -->
                    <label for="ad-form">New release details</label>
                    <form role="form" class="form" id="ad-release-form" name="add-release-form">
                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control" id="artist" name="artist" />
                            <label for="album">Album title</label>
                            <input type="text" class="form-control" id="album" name="album" />
                            <label for="date">Release date</label>
                            <input type="text" class="form-control" id="date" name="date" />
                        </div>
                        <div class="form-group">
                            <label for="code">Release code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Eg. VOR009" />
                            <label for="code">Released as CD</label>
                            <label><input type="radio" name="has-cd" />Yes</label>
                            <label><input type="radio" name="has-cd" />No</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="Submit" id="send-release-form">Add the album</button>
                    </form>
                    <div id="added-ok" class="text-success" hidden>Successfully added release! Boom...</div>
                    <div id="add-failed" class="text-danger" hidden>Failed to add release!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
