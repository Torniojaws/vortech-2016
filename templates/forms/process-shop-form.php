<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Mandatory fields
    $shop_category = (int) $_POST['shop-category'];
    $product_name = $_POST['name'];
    $description = $_POST['description'];
    $price = (float) $_POST['price'];

    // Optional fields
    $paypal_button = $_POST['pp-button'];
    $paypal = $_POST['paypal'];
    $bandcamp = $_POST['bandcamp'];
    $amazon = $_POST['amazon'];
    $spotify = $_POST['spotify'];
    $deezer = $_POST['deezer'];
    $itunes = $_POST['itunes'];

    if ($shop_category == 1) {
        $is_album = false;
    } else {
        $is_album = true;
    }

    // If the item is a CD or Digital Album
    if ($is_album) {
        // It will NOT contain an uploaded thumbnail - We'll use the release photo instead
        $release_code = $_POST['selected-album'];

        // We'll link to the photo of the release
        $release_api = 'api/v1/releases/'.$release_code;
        $release_details = file_get_contents(SERVER_URL.$release_api);
        $release = json_decode($release_details, true);
        $thumbnail = $release[0]['thumbnail'];
        $full = $release[0]['full'];
        $release_id = (int) $release['id'];
    } else {
        // Other types of shop items can/should have a photo uploaded
        $photo_count = 0;
        $thumbnail_errors = 0;
        $thumbnail_path = IMAGE_DIR.'merch/thumbnails/';
        $full_image_path = IMAGE_DIR.'merch/';

        foreach ($_FILES as $file => $details) {
            ++$photo_count;
            $tmp = $details['tmp_name'];
            $target = $details['name'];
            try {
                if (move_uploaded_file($tmp, $thumbnail_path.$target) == false) {
                    // Create thumbnail and copy it to the target path
                    require_once $root.'classes/ImageResizer.php';
                    $resizer = new ImageResizer($root);
                    /*
                     * params:
                     * Full image path
                     * target path for thumbnail
                     * target width of thumbnail
                     */
                    $original = $thumbnail_path.$target;
                    $thumbnail_fullpath = $thumbnail_path;
                    $thumb_filename = $target;
                    $resizer->createThumbnail($original, $thumbnail_fullpath, $thumb_filename, 200);
                    if ($resizer->thumbnailStatus() == false) {
                        $thumbnail_errors += 1;
                    }
                }
            } catch (Exception $ex) {
                echo 'Got exception: '.$ex;
            }
        }
        $thumbnail = 'thumbnails/'.$target;
        $full = $target;
        $release_id = (int) '0'; // Not used for non-CD/Digital items
    }

    if ($_SESSION['authorized'] == 1 && isset($product_name) && isset($price) && $price > 0
        && strlen($description) > 0  && isset($full) && isset($thumbnail)) {
        require_once $root.'/api/classes/Database.php';

        $db = new Database();

        $db->connect();
        $statement = 'INSERT INTO shop_items VALUES(
            0,
            :category_id,
            :product_name,
            :conditional_album_id,
            :description,
            :price,
            :full,
            :thumbnail,
            :paypal_button,
            :paypal_link,
            :bandcamp_link,
            :amazon_link,
            :spotify_link,
            :deezer_link,
            :itunes_link
        )';
        $params = array(
            'category_id' => $shop_category,
            'product_name' => $product_name,
            'conditional_album_id' => $release_id,
            'description' => $description,
            'price' => $price,
            'full' => $full,
            'thumbnail' => $thumbnail,
            'paypal_button' => $paypal_button,
            'paypal_link' => $paypal,
            'bandcamp_link' => $bandcamp,
            'amazon_link' => $amazon,
            'spotify_link' => $spotify,
            'deezer_link' => $deezer,
            'itunes_link' => $itunes,
        );
        $db->run($statement, $params);
        $db->close();

        if ($db->querySuccessful()) {
            $response['status'] = 'success';
            $response['message'] = 'Shop item added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add shop item to DB!';
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Missing shop item details';
            $missing_items = empty_mandatories();
            $response['empty-items'] = $missing_items;
        }
    }

    /**
     * Lists all mandatory details that are empty.
     */
    function empty_mandatories()
    {
        $empties = array();
        if (isset($shop_category) == false) {
            $empties[] .= 'shop_category';
        }
        if (isset($product_name) == false) {
            $empties[] .= 'product_name';
        }
        if (isset($release_id) == false) {
            $empties[] .= 'release_id';
        }
        if (isset($description) == false) {
            $empties[] .= 'description';
        }
        if (isset($price) == false) {
            $empties[] .= 'price';
        }
        if (isset($full) == false) {
            $empties[] .= 'full';
        }
        if (isset($thumbnail) == false) {
            $empties[] .= 'thumbnail';
        }

        return $empties;
    }

    header('Content-type: application/json');
    echo json_encode($response);

    $params = array(
        'category_id' => $shop_category,
        'product_name' => $product_name,
        'conditional_album_id' => $release_id,
        'description' => $description,
        'price' => $price,
        'full' => $full,
        'thumbnail' => $thumbnail,
        'paypal_button' => $paypal_button,
        'paypal_link' => $paypal,
        'bandcamp_link' => $bandcamp,
        'amazon_link' => $amazon,
        'spotify_link' => $spotify,
        'deezer_link' => $deezer,
        'itunes_link' => $itunes,
    );
