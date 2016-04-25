<div class="row">
    <h3>Edit Profile</h3>
    <p>Feel free to update your information below</p>
    <hr />

    <!-- Get current details -->
    <?php
        // TODO: how to do this without session?
        $user_api = 'api/v1/users/'.$_SESSION['username'];
        $user_list = file_get_contents(SERVER_URL.$user_api);
        $user_details = json_decode($user_list, true);
        $user = $user_details[0];
    ?>

    <label for="profile-form">Edit user profile</label>
    <form role="form" class="form" id="profile-form" name="profile-form">
        <div class="form-group">
            <!-- Edit display name -->
            <label for="profileName">Edit display name</label>
            <input type="text" class="form-control" id="profileName" name="profileName"
                   placeholder="Update display name" value="<?php echo $user['name']; ?>">

            <!-- Edit login name -->
            <label for="profileUsername">Edit login/username</label>
            <input type="text" class="form-control" id="profileUsername" name="profileUsername"
                   placeholder="Update login/username" value="<?php echo $user['username']; ?>">

            <!-- Change password -->
            <label for="profilePassword">Change password</label>
            <input type="password" class="form-control" id="profileOldPassword" name="profileOldPassword" placeholder="Current password">
            <input type="password" class="form-control" id="profileNewPassword1" name="profileNewPassword1" placeholder="New password">
            <input type="password" class="form-control" id="profileNewPassword2" name="profileNewPassword2" placeholder="New password again">

            <!-- Edit avatar -->
            <label for="avatar">Upload new avatar</label>
            <small>Will be resized to 64 pixels wide</small><br />
            <br />
            <span class="btn btn-default btn-file">
                Browse <input type="file" id="avatar" name="avatar" />
            </span>

            <!-- Add personal text/caption -->
            <label for="profileCaption">Short personal text (max 60 characters)</label>
            <input type="text" class="form-control" id="profileCaption" name="profileCaption"
                   placeholder="Short personal text (max 60 chars)" value="<?php echo $user['caption']; ?>">
        </div>
    </form>
    <div id="login-ok" class="text-success" hidden>Successfully logged in! Enjoy...</div>
    <div id="login-failed" class="text-danger" hidden>Incorrect login</div>
</div>
