<div class="container-fluid">
    <div class="row">
        <h3>Edit Your Profile</h3>
        <p>Feel free to update your information below. Press the "Save Changes" button below, when you are ready.</p>
        <hr />

        <?php
            // Get user details
            $root = str_replace('templates/partials', '', dirname(__FILE__));
            require_once $root.'constants.php';

            $user_api = 'api/v1/users/'.$_SESSION['username'];
            $user_list = file_get_contents(SERVER_URL.$user_api);
            $user_details = json_decode($user_list, true);
            $user = $user_details[0];
        ?>

        <form role="form" class="form" id="profile-form" name="profile-form">
            <div class="form-group">
                <div class="col-sm-6">
                    <!-- Edit display name -->
                    <label for="profileName">Edit display name</label>
                    <input type="text" class="form-control" id="profileName" name="profileName"
                           placeholder="Update display name" value="<?php echo $user['name']; ?>">

                    <!-- Edit login name -->
                    <label for="profileUsername">Edit login/username</label>
                    <input type="text" class="form-control" id="profileUsername" name="profileUsername"
                           placeholder="Update login/username" value="<?php echo $user['username']; ?>">
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
                    <small>Current password is needed when changing</small>
                    <input type="password" class="form-control" id="profileOldPassword" name="profileOldPassword" placeholder="Current password">
                    <input type="password" class="form-control" id="profileNewPassword1" name="profileNewPassword1" placeholder="New password">
                    <input type="password" class="form-control" id="profileNewPassword2" name="profileNewPassword2" placeholder="New password again">
                    <br />

                    <!-- Edit avatar -->
                    <p><strong>Current avatar:</strong></p>
                    <?php
                        $thumb_path = IMAGE_DIR.'user_photos/'.$user['thumbnail'];
                        if (file_exists($thumb_path)) {
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
