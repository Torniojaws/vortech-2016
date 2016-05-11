<div class="container-fluid">
    <h4>Admin login</h4>
    <form class="form-inline" id="ad-form" name="add-form">
        <div class="form-group">
            <label for="adUser">Name</label>
            <input type="text" class="form-control" id="adUser" name="adUser" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="adPass">Pass</label>
            <input type="password" class="form-control" id="adPass" name="adPass" placeholder="Pass">
        </div>
        <button type="submit" class="btn btn-primary" name="Submit" id="send-ad-form">Enter the fray</button>
    </form>
    <div id="login-ok" class="text-success" hidden>Successfully logged in! Enjoy...</div>
    <div id="login-failed" class="text-danger" hidden>Incorrect login</div>
    <div id="login-unauthorized" class="text-danger" hidden>Unauthorized</div>
</div>
