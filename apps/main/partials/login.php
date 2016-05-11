<div class="container-fluid">
    <h4>User Login</h4>
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
