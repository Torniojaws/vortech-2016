<div class="container-fluid">
    <div class="row text-center">
        <label for="news-btn">Admin - Add photos</label><br />
        <button type="button" class="btn btn-primary" id="photo-btn" data-toggle="modal" data-target="#photo-form">
            Open Form
        </button>
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
                    <form class="form" id="ad-photos-form" name="add-photos-form"
                          enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="category">Select Category</label>
                            <select class="form-control" id="category" name="album-category">
                            <?php
                                require_once 'constants.php';
                                $category_api = 'api/v1/photos/categories';
                                $category_list = file_get_contents(SERVER_URL.$category_api);
                                $categories = json_decode($category_list, true);

                                foreach ($categories as $category) {
                                    echo '<option value="'.$category['name_id'].'">';
                                    echo $category['name'].'</option>'.PHP_EOL;
                                }
                            ?>
                            </select>
                            <!-- Radio button to switch between selecting existing album or creating new -->
                            <label for="code">Use existing photo album?</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="use-existing" value="1" />
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="use-existing" value="2" />
                                    No
                                </label>
                            </div>
                            <!-- Only if radio button for existing is yes -->
                            <div id="show1" class="toHide" style="display:none;">
                                <label for="text">Select Existing Album</label>
                                <select class="form-control" id="selected-album" name="selected-album">
                                <?php
                                    $albums_api = 'api/v1/photos/albums';
                                    $albums_list = file_get_contents(SERVER_URL.$albums_api);
                                    $albums = json_decode($albums_list, true);

                                    foreach ($albums as $album) {
                                        echo '<option value="'.$album['id'].'" ';
                                        echo 'data-tag="'.$album['name_id'].'">';
                                        echo $album['name'].'</option>'.PHP_EOL;
                                    }
                                ?>
                                </select>
                            </div>
                            <!-- Only shown if radio button for existing is no -->
                            <div id="show2" class="toHide" style="display:none;">
                                <h2>Create New Album</h2>
                                <div class="form-group" id="new-album">
                                    <!-- The below is hidden for compatibility reasons -->
                                    <select class="form-control" id="category-newalbum" name="category-newalbum" hidden>
                                    <?php
                                        foreach ($categories as $category) {
                                            echo '<option value="'.$category['id'].'" ';
                                            echo 'data-tag="'.$category['name_id'].'">';
                                            echo $category['name'].'</option>'.PHP_EOL;
                                        }
                                    ?>
                                    </select>
                                    <label for="name-newalbum">Name for new album</label>
                                    <input type="text" class="form-control" id="name-newalbum"
                                           name="name" placeholder="Album name" />
                                    <label for="description-newalbum">Description for the new album</label>
                                    <textarea class="form-control" rows="5" id="description-newalbum"
                                              name="description" placeholder="Write the description here"></textarea>
                                    <label for="code">Show in album gallery?</label>
                                    <div class="radio">
                                        <label><input type="radio" name="gallery-newalbum" value="yes" />Yes</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="gallery-newalbum" value="no" />No</label>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <label for="date-photos">Date for the photos</label>
                            <input type="text" class="form-control" id="date-newalbum"
                                   name="date" placeholder="yyyy-mm-dd hh:mm:ss" />
                            <label for="taken-by">Pictures taken by</label>
                            <input type="text" class="form-control" id="takenby-newalbum"
                                   name="taken-by" placeholder="Name" />
                            <label for="photos">Photos</label><br />
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="photo" name="photo" />
                            </span><br />
                            <small>Captions can be added after upload</small>
                        </div>

                        <button type="submit" class="btn btn-primary" name="Submit" id="send-photos-form">
                            Add the photos
                        </button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added photos! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add photos!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
