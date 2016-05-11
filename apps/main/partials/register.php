<div class="row">
    <div class="col-sm-4">
        <h2>Registration Form</h2>
        <p>As mentioned, registered users can add comments to News, Releases, Songs, Shows, Photos,
        and Videos. You can also have a custom avatar/image.</p>
        <hr />
        <form class="form" id="register-form" name="register-form">
            <div class="form-group">
                <!-- Display name -->
                <label for="registerUser">Your display name</label><br />
                <small>When you post a comment, this will be shown as your name</small>
                <input type="text" class="form-control" id="registerName" name="registerName"
                       placeholder="Display name">

                <!-- Login name -->
                <label for="registerUser">Your username</label><br />
                <small>Used for logging in</small>
                <input type="text" class="form-control" id="registerUsername" name="registerUsername"
                       placeholder="Name">

                <!-- Password -->
                <label for="registerPass">Password</label>
                <p class="text-warning">Please use a password that you don't use elsewhere, just to be
                    safe. While security is taken care of to a good standard, this just a simple login for
                    some extra features. The password will be stored in encrypted form, so it can
                    only be reset, but not retrieved by admin.</p>
                <input type="password" class="form-control" id="registerPassword"
                       name="registerPassword" placeholder="Pass">
                <!-- Confirm password -->
                <label for="registerPassConfirm">Password again</label>
                <small>Must match above</small>
                <input type="password" class="form-control" id="registerPasswordConfirm"
                       name="registerPasswordConfirm" placeholder="Pass">
                <!-- User avatar -->
                <label for="photos">Upload your avatar</label>
                <small>Will be resized to 64 pixels wide</small><br />
                <small>You can also add or change it later</small>
                <br />
                <span class="btn btn-default btn-file">
                    Browse <input type="file" id="photo" name="photo" />
                </span><br />
            </div>
            <button type="submit" class="btn btn-primary" name="Submit" id="send-register-form">
                Register
            </button>
        </form>
        <div id="register-ok" class="text-success" hidden>Successfully registered! Enjoy...</div>
        <div id="register-failed" class="text-danger" hidden>Could not register - try again later!</div>
    </div>
</div>
