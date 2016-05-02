<?php
    if ($_SESSION['authorized'] == 1) {
        include './apps/bio/admin/add-member-modal.php';
    }
?>

<div class="row">
    <div class="col-sm-12">
        <h1>Biography</h1>
        <article id="biofull-1"<?php if ($_SESSION['authorized'] == 1) {
    echo ' class="edit-bio"';
} ?>><?php
                $bio_api = 'api/v1/articles/1';
                $bio_details = file_get_contents(SERVER_URL.$bio_api);
                $bio_details = json_decode($bio_details, true);
                $biography = $bio_details[0];

                echo $biography['full'];
            ?></article>
    </div>
</div>

<?php

    $api = 'api/v1/members';
    $members_list_json = file_get_contents(SERVER_URL.$api);

    // json_decode() with param2 as "true" converts the data to an array
    $members = json_decode($members_list_json, true);

    // All biography texts for members
    $biographies_api = 'api/v1/articles?category=members';
    $biographies_list = file_get_contents(SERVER_URL.$biographies_api);
    $biographies = json_decode($biographies_list, true);

    echo '<h2>Band members</h2>';
    foreach ($members as $member) {
        $photo_api = 'api/v1/photos/'.$member['photo_id'];
        $photo = file_get_contents(SERVER_URL.$photo_api);
        $photo = json_decode($photo, true);
        // The array will always contain just one item, so we'll use the first
        $photo = $photo[0];

        // Biography text for current member
        $member_bio = '';
        foreach ($biographies as $member_biography) {
            if ($member_biography['subid'] == $member['id']) {
                $member_bio = $member_biography;
                break;
            }
        }
        include './apps/bio/partials/bio.php';
    }
