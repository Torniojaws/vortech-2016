<div class="container-fluid">
    <div class="row text-center">
        <label for="shop-btn">Admin - Add shop item</label><br />
        <button type="button" class="btn btn-primary" id="shop-btn" data-toggle="modal" data-target="#shop-form">
            Open Form
        </button>
    </div>

    <!-- Modal for shop details -->
    <div class="modal fade" id="shop-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add shop item</h4>
                </div>
                <div class="modal-body">
                    <!-- Add shop item -->
                    <form class="form" id="ad-shopitem-form" name="add-shopitem-form"
                          enctype="multipart/form-data">

                        <div class="form-group">
                            <!-- Select category -->
                            <label for="category">Select Category</label>
                            <select class="form-control" id="shop-category" name="shop-category">
                            <?php
                                require_once 'constants.php';
                                $category_api = 'api/v1/shopitems/categories';
                                $category_list = file_get_contents(SERVER_URL.$category_api);
                                $categories = json_decode($category_list, true);

                                foreach ($categories as $category) {
                                    echo '<option value="'.$category['id'].'">';
                                    echo $category['title'].'</option>'.PHP_EOL;
                                }
                            ?>
                            </select>

                            <!-- Product name -->
                            <label for="name">Product name/title</label>
                            <input type="text" class="form-control" id="name"
                                   name="name" placeholder="Eg. CD - Album Title" />

                            <!-- Only if shop item is an album (= cd / digital) -->
                            <div id="release" class="toHide" style="display:none;">
                                <label for="text">Select existing release
                                    <small class="text-muted">
                                        (The expectation is that a new release is first added to releases)
                                    </small>
                                </label>
                                <select class="form-control" id="selected-album" name="selected-album">
                                <?php
                                    $albums_api = 'api/v1/releases';
                                    $albums_list = file_get_contents(SERVER_URL.$albums_api);
                                    $albums = json_decode($albums_list, true);

                                    foreach ($albums as $album) {
                                        echo '<option value="'.$album['release_code'].'" ';
                                        echo 'data-tag="'.$album['release_id'].'">';
                                        echo $album['title'].'</option>'.PHP_EOL;
                                    }
                                ?>
                                </select>
                            </div>

                            <!-- Description -->
                            <label for="description">Item description</label>
                            <input type="text" class="form-control" id="description"
                                   name="description" placeholder="Eg. New t-shirt for 2016" />

                            <!-- Price -->
                            <label for="price">Item price</label>
                            <input type="text" class="form-control" id="price"
                                   name="price" placeholder="Can be just 15 or eg. 14.99 (no comma)" />

                            <!-- Upload image (if album, not needed) -->
                            <div id="shop-photo" class="toHide">
                                <label for="photo">Photo</label><br />
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" id="photo" name="photo" />
                                </span><br />
                            </div>

                            <hr />
                            <h3 class="text-info">External links <small>(Optional)</small></h3>

                            <!-- Paypal Button -->
                            <label for="price">PayPal Button</label>
                            <input type="text" class="form-control" id="pp-button"
                                   name="pp-button" placeholder="PayPal Button embedded code" />

                            <!-- Links to external shops like BandCamp -->
                            <label for="price">PayPal link</label>
                            <input type="text" class="form-control" id="paypal"
                                   name="paypal" placeholder="PayPal link" />

                            <label for="price">BandCamp link</label>
                            <input type="text" class="form-control" id="bandcamp"
                            name="bandcamp" placeholder="BandCamp link" />

                            <label for="price">Amazon link</label>
                            <input type="text" class="form-control" id="amazon"
                            name="amazon" placeholder="Amazon link" />

                            <label for="price">Amazon link</label>
                            <input type="text" class="form-control" id="spotify"
                            name="spotify" placeholder="Spotify link" />

                            <label for="price">Amazon link</label>
                            <input type="text" class="form-control" id="deezer"
                            name="deezer" placeholder="Deezer link" />

                            <label for="price">Amazon link</label>
                            <input type="text" class="form-control" id="itunes"
                            name="itunes" placeholder="iTunes link" />

                        </div>
                        <button type="submit" class="btn btn-primary" name="Submit" id="send-shopitem-form">
                            Add the shop item
                        </button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added shop item! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add shop item!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
