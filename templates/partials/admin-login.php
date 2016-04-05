<div class="container-fluid">
    <label for="ad-form">Admin login</label>
    <form role="form" class="form-inline" id="ad-form" name="add-form">
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
    <div class="notification text-success" hidden>Successfully logged in! Enjoy...</div>
</div>
