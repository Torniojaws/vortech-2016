<!-- Register modal -->
<div class="modal fade" id="register-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Register -->
                        <form class="form" id="register-form" name="register-form">
                            <div class="form-group">
                                <!-- Display name -->
                                <label for="registerName">Your display name</label><br />
                                <small>When you post a comment, this will be shown as your name</small>
                                <input type="text" class="form-control" id="registerName" name="registerName"
                                       placeholder="Display name">

                                <!-- Login name -->
                                <label for="registerUsername">Your username</label><br />
                                <small>Used for logging in</small>
                                <input type="text" class="form-control" id="registerUsername" name="registerUsername"
                                       placeholder="Name">

                                <!-- Password -->
                                <label for="registerPassword">Password</label>
                                <p class="text-warning">Please use a password that you don't use elsewhere, just to be
                                    safe. While security is taken care of to a good standard, this just a simple login for
                                    some extra features. The password will be stored in encrypted form, so it can
                                    only be reset, but not retrieved by admin.</p>
                                <input type="password" class="form-control" id="registerPassword"
                                       name="registerPassword" placeholder="Pass">
                                <!-- Confirm password -->
                                <label for="registerPasswordConfirm">Password again</label>
                                <small>Must match above</small>
                                <input type="password" class="form-control" id="registerPasswordConfirm"
                                       name="registerPasswordConfirm" placeholder="Pass">
                                <!-- User avatar -->
                                <label for="photo">Upload your avatar</label>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
