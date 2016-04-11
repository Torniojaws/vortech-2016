<div class="container-fluid">
    <div class="row text-center">
        <label for="news-btn">Admin - Add photos</label><br />
        <button type="button" class="btn btn-primary" id="photo-btn" data-toggle="modal" data-target="#photo-form">Open Form</button>
    </div>

    <!-- Modal for photo details -->
    <div class="modal fade" id="photo-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add photos</h4>
                </div>
                <div class="modal-body">
                    <!-- Add photos -->
                    <form role="form" class="form" id="ad-photos-form" name="add-photos-form">

                        <div class="form-group">
                            <label for="category">Select Category</label>
                            <select class="form-control" id="category">
                            <?php
                                require_once 'constants.php';
                                $category_api = 'api/v1/photos/categories';
                                $category_list = file_get_contents(SERVER_URL.$category_api);
                                $categories = json_decode($category_list, true);

                                foreach ($categories as $category) {
                                    echo '<option value="'.$category['name_id'].'">'.$category['name'].'</option>'.PHP_EOL;
                                }
                            ?>
                            </select>
                            <!-- Radio button to switch between selecting existing album or creating new -->
                            <label for="code">Use existing photo album?</label>
                            <div class="radio">
                                <label><input type="radio" name="use-existing" value="yes" checked="checked" />Yes</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="use-existing" value="no" />No</label>
                            </div>
                            <!-- Only if radio button for existing is yes -->
                            <div id="existing">
                                <label for="text">Select Existing Album</label>
                                <select class="form-control" id="selected-album">
                                <?php
                                    $albums_api = 'api/v1/photos/albums';
                                    $albums_list = file_get_contents(SERVER_URL.$albums_api);
                                    $albums = json_decode($albums_list, true);

                                    foreach ($albums as $album) {
                                        echo '<option value="'.$album['id'].'">'.$album['name'].'</option>'.PHP_EOL;
                                    }
                                ?>
                                </select>
                            </div>
                            <!-- Only shown if radio button for existing is no -->
                            <div id="create-new">
                                <label for="new-album">Create New Album</label>
                                <div class="form-group" id="new-album">
                                    <label for="category-newalbum">Select Category</label>
                                    <select class="form-control" id="category-newalbum">
                                    <?php
                                        foreach ($categories as $category) {
                                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>'.PHP_EOL;
                                        }
                                    ?>
                                    </select>
                                    <label for="name-newalbum">Name for new album</label>
                                    <input type="text" class="form-control" id="name-newalbum" name="name" placeholder="Album name" />
                                    <label for="description-newalbum">Description for the new album</label>
                                    <textarea class="form-control" rows="5" id="description-newalbum" name="description" placeholder="Write the description here"></textarea>
                                    <label for="code">Show in album gallery?</label>
                                    <div class="radio">
                                        <label><input type="radio" name="gallery-newalbum" value="yes" />Yes</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="gallery-newalbum" value="no" />No</label>
                                    </div>
                                </div>
                            </div>
                            <textarea class="form-control" rows="5" id="text" name="text" placeholder="Write your news here"></textarea>
                            <label for="tags">Tags for the news <small class="text-muted">(separate with comma)</small></label>
                            <input type="text" class="form-control" id="tags" name="tags" placeholder="Tag 1, Tag 2, Tag 3, ..." />
                        </div>

                        <button type="submit" class="btn btn-primary" name="Submit" id="send-news-form">Add the news</button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added news! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add news!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
