<?php

    session_start();

    // Because this runs from a subdir /root/templates/forms
    $root = str_replace('templates/forms', '', dirname(__FILE__));
    require_once $root.'constants.php';

    // Mandatory fields
    $shop_category = $_POST['shop-category'];
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

    // If the item is a CD or Digital Album
    if (isset($_POST['selected-album'])) {
        // It will NOT contain an uploaded thumbnail - We'll use the release photo instead
        $release_code = $_POST['selected-album'];

        // We'll link to the photo of the release
        $release_api = 'api/v1/releases/'.$release_code;
        $release_details = file_get_contents(SERVER_URL.$release_api);
        $release = json_decode($release_details, true);
        $thumbnail = $release['thumbnail'];
        $full = $release['full'];
        $release_id = (int) $release['id'];
    } else {
        // Other types of shop items can/should have a thumbnail uploaded
        $thumbnail_path = 'merch/thumbnails/';
        $thumbnail_upload_path = $root.'/static/img/'.$thumbnail_path;
        foreach ($_FILES as $file => $details) {
            $tmp = $details['tmp_name'];
            $target = $details['name'];
            try {
                move_uploaded_file($tmp, $thumbnail_upload_path.$target);
            } catch (Exception $ex) {
                die($ex);
            }
        }
        $thumbnail = 'thumbnails/'.$target;
        $full = $target;
        $release_id = (int) "0"; // Not used for non-CD/Digital items
    }



    if ($_SESSION['authorized'] == 1 && isset($product_name)
        && isset($price) && $price > 0 && strlen($description) > 0) {
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
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);
