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

    $thumbnail_errors = 0;
    $image_errors = 0;

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
        require_once $root.'classes/ImageUploader.php';
        $absolute_upload_path = $root.IMAGE_DIR.'merch/';

        $imageUploader = new ImageUploader($root, $absolute_upload_path);
        $imageUploader->processUploadedImages();
        // Each array element contains info about one successfully uploaded image
        $uploads = $imageUploader->getAssocArrayOfUploadedImages();

        // Thumbnail creation
        require_once $root.'classes/ImageResizer.php';
        $resizer = new ImageResizer($root);

        foreach ($uploads as $image) {
            $resizer->createThumbnail(
                $image['fullpath'].$image['filename'],
                $absolute_upload_path.'thumbnails/',
                $image['filename'],
                200
            );
        }

        // Check that everything went OK
        if ($imageUploader->successfullyUploadedAll() == false) {
            $image_errors += 1;
        }
        if ($resizer->thumbnailStatus() == false) {
            $thumbnail_errors += 1;
        }

        $full = $image['filename'];
        $thumbnail = 'thumbnails/'.$image['filename'];
        $release_id = (int) '0'; // Not used for non-CD/Digital items
    }

    if ($_SESSION['authorized'] == 1 && isset($product_name) && isset($price) && $price > 0
        && strlen($description) > 0  && isset($full) && isset($thumbnail) && $image_errors == 0
        && $thumbnail_errors == 0) {
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

        if ($db->querySuccessful() && $image_errors == 0 && $thumbnail_errors == 0) {
            $response['status'] = 'success';
            $response['message'] = 'Shop item added to DB';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add shop item to DB!';
            if ($image_errors > 0) {
                $response['message'] .= ' Image upload failed.';
            }
            if ($thumbnail_errors > 0) {
                $response['message'] .= ' Thumbnail creation failed.';
            }
        }
    } else {
        if (isset($_SESSION['authorized']) == false) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        } elseif ($image_errors > 0 or $thumbnail_errors > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Failed to add to DB!';
            if ($image_errors > 0) {
                $response['message'] .= ' Image upload failed.';
            }
            if ($thumbnail_errors > 0) {
                $response['message'] .= ' Thumbnail creation failed.';
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
