<div class="container-fluid">
    <div class="row text-center">
        <label for="release-btn">Admin - Add new video</label><br />
        <button type="button" class="btn btn-primary" id="video-btn" data-toggle="modal" data-target="#video-form">Open Form</button>
    </div>

    <!-- Modal for video details -->
    <div class="modal fade" id="video-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add new video</h4>
                </div>
                <div class="modal-body">
                    <!-- Add new video -->
                    <h4>New video details</h4>
                    <form class="form" id="ad-video-form" name="add-video-form"
                          enctype="multipart/form-data">
                        <!-- Mandatory details -->
                        <div class="form-group">
                            <label for="artist">Video title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title for video" />
                            <label for="artist">Video URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="http://www.videosite.com/video/123" />
                            <label for="album">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="00:25:00" />
                            <label for="category">Video category</label>
                            <select class="form-control" id="category" name="category">
                            <?php
                                $video_api = 'api/v1/videos/categories';
                                $cat_list = file_get_contents(SERVER_URL.$video_api);
                                $categories = json_decode($cat_list, true);
                                foreach ($categories as $category) {
                                    echo '<option value="'.$category['id'].'" ';
                                    echo 'data-tag="'.$category['id'].'">';
                                    echo $category['name'].'</option>'.PHP_EOL;
                                }
                            ?>
                            </select>
                            <label for="album">Thumbnail</label><br />
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="thumbnail" name="thumbnail" />
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary" name="Submit" id="send-video-form">Add the video</button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added video! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add video!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
