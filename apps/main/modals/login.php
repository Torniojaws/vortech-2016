<!-- Login modal -->
<div class="modal fade" id="login-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Login -->
                        <label for="login-form">User Login</label>
                        <form class="form-inline" id="login-form" name="login-form">
                            <div class="form-group">
                                <label for="loginUser">Username</label>
                                <input type="text" class="form-control" id="loginUser" name="loginUser" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="loginPass">Password</label>
                                <input type="password" class="form-control" id="loginPass" name="loginPass" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary" name="Submit" id="send-login-form">Login</button>
                        </form>
                        <div id="login-ok" class="text-success" hidden>Successfully logged in! Enjoy...</div>
                        <div id="login-failed" class="text-danger" hidden>Incorrect login</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
