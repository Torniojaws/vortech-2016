<div class="container-fluid">
    <div class="row">
        <?php
            $root = str_replace('apps/profile/partials', '', dirname(__FILE__));
            require_once $root.'constants.php';

            // Get user details
            $user_api = 'api/v1/users/'.$_SESSION['username'];
            $user_list = file_get_contents(SERVER_URL.$user_api);
            $user_details = json_decode($user_list, true);
            $user = $user_details[0];
        ?>
        <h3>Recent activity <small>5 most recent posts - Only visible to you</small></h3>
        <?php
            // Recent activity (eg. comments and votes)
            $activity_api = 'api/v1/users/'.$user['id'].'/activities';
            $activity_list = file_get_contents(SERVER_URL.$activity_api);
            $activities = json_decode($activity_list, true);

            // The JSON is an array of arrays, so this check makes sure no strange data is shown
            if (empty($activities[0]) == false) {
                foreach ($activities as $activity) {
                    include 'apps/profile/partials/activity.php';
                }
            } else {
                echo '<small>(No activities yet)</small>';
            }
        ?>
    </div>
    <div class="row">
        <h3>Edit Your Profile</h3>
        <p>Feel free to update your information below. Press the "Save Changes" button below, when you are ready.</p>
        <hr />
        <form class="form" id="profile-form" name="profile-form">
            <div class="form-group">
                <div class="col-sm-6">
                    <!-- Edit display name -->
                    <label for="profileName">Edit display name</label>
                    <input type="text" class="form-control" id="profileName" name="profileName"
                           placeholder="Update display name" value="<?php echo $user['name']; ?>">

                    <!-- Edit login name -->
                    <label for="profileUsername">Edit login/username</label>
                    <p class="text-danger"><strong>Note:</strong> If you change your username, you
                        will be automatically logged out and you will need to login again</p>
                    <input type="text" class="form-control" id="profileUsername" name="profileUsername"
                           placeholder="Update login/username" value="<?php echo $user['username']; ?>">
                    <!-- When changing username, we need the old username to update the DB -->
                    <input type="hidden" class="form-control" id="profileOldUsername" name="profileOldUsername"
                           value="<?php echo $user['username']; ?>">
                    <!-- Add personal text/caption -->
                    <label for="profileCaption">Short personal text (max 60 characters)</label>
                    <input type="text" class="form-control" id="profileCaption" name="profileCaption"
                           placeholder="Short personal text (max 60 chars)" value="<?php echo $user['caption']; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <!-- Change password -->
                    <label for="profilePassword">Change password</label>
                    <p class="text-danger"><strong>Note:</strong> If you change your password, you
                        will be automatically logged out and you will need to login again</p>
                    <input type="password" class="form-control" id="profileOldPassword" name="profileOldPassword" placeholder="Current password">
                    <input type="password" class="form-control" id="profileNewPassword1" name="profileNewPassword1" placeholder="New password">
                    <input type="password" class="form-control" id="profileNewPassword2" name="profileNewPassword2" placeholder="New password again">
                    <br />

                    <!-- Edit avatar -->
                    <p><strong>Current avatar:</strong></p>
                    <?php
                        $thumb_path = IMAGE_DIR.'user_photos/'.$user['thumbnail'];
                        if (empty($user['thumbnail']) == false) {
                            echo '<img src="'.$thumb_path.'" alt="'.$user['name'].'" /><br/>';
                        } else {
                            echo '<p>(No image uploaded)</p>';
                        }
                    ?>
                    <label for="avatar">Upload new avatar</label>
                    <small>Will be resized to 64 pixels wide</small>
                    <br />
                    <span class="btn btn-default btn-file">
                        Browse <input type="file" id="avatar" name="avatar" />
                    </span>
                    <br />
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="Submit" id="update-profile-form">
                Save Changes
            </button>
        </form>
        <div id="login-ok" class="text-success" hidden>Successfully logged in! Enjoy...</div>
        <div id="login-failed" class="text-danger" hidden>Incorrect login</div>
    </div>
</div>
