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
                <div class="modal-body">
                    <!-- Add new release -->
                    <label for="ad-form">New release details</label>
                    <form role="form" class="form" id="ad-release-form" name="add-release-form">
                        <!-- Mandatory details -->
                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control" id="artist" name="artist" placeholder="Vortech" />
                            <label for="album">Album title</label>
                            <input type="text" class="form-control" id="album" name="album" placeholder="Album title" />
                            <label for="date">Release date</label>
                            <input type="text" class="form-control" id="date" name="date" placeholder="yyyy-mm-dd hh:mm:ss" />
                        </div>
                        <!-- Additional details -->
                        <div class="form-group">
                            <label for="songs">Songs <small class="text-muted">One song per row in format: [# title (01:23)]</small></label>
                            <textarea class="form-control" rows="5" id="songs" name="songlist" placeholder="# title (01:23)"></textarea>
                            <label for="code">
                                Release Code
                                <small class="text-muted">
                                    (most recent code was:
                                    <?php
                                        require_once 'constants.php';
                                        $album_api = 'api/v1/releases/latest';
                                        $query = file_get_contents(SERVER_URL.$album_api);
                                        $data = json_decode($query, true);
                                        echo $data[0]['release_code'];
                                    ?>)
                                </small>
                            </label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Eg. VOR009" />
                            <label for="code">Released as CD</label>
                            <div class="radio">
                                <label><input type="radio" name="has-cd" value="yes" />Yes</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="has-cd" value="no" />No</label>
                            </div>
                            <label for="date">When to publish this album on website (date in the past = immediately)</label>
                            <input type="text" class="form-control" id="web-publish-date" name="web-publish-date" placeholder="yyyy-mm-dd hh:mm:ss" />
                        </div>
                        <button type="submit" class="btn btn-primary" name="Submit" id="send-release-form">Add the album</button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added release! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add release!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
