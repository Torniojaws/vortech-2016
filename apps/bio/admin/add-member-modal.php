<div class="container-fluid">
  <div class="row text-center">
    <label for="news-btn">Admin - Add member</label><br />
    <button type="button" class="btn btn-primary" id="member-btn" data-toggle="modal"
            data-target="#member-form">
      Open Form
    </button>
  </div>

  <!-- Modal for member details -->
  <div class="modal fade" id="member-form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add member</h4>
        </div>
        <div class="modal-body">
          <!-- Add member -->
          <form class="form" id="ad-member-form" name="add-member-form"
                enctype="multipart/form-data">

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name"
                     name="name" placeholder="Member name" />
              <label for="category">Select Type</label>
              <select class="form-control" id="type" name="member-type">
                <option value="Full member">Full member</option>
                <option value="Rehearsal member">Rehearsal member</option>
                <option value="Guest artist">Guest artist</option>
              </select>
              <label for="instrument">Instrument(s) <small>(comma-separated)</small></label>
              <input type="text" class="form-control" id="instrument"
                     name="instrument" placeholder="Instrument names" />
              <label for="started">Start date</label>
              <input type="text" class="form-control" id="started"
                     name="started" placeholder="yyyy-mm-dd H:m:s" />
              <label for="quit">Quit date (leave empty for active)</label>
              <input type="text" class="form-control" id="quit"
                     name="quit" placeholder="yyyy-mm-dd H:m:s" />
              <label for="photo">Photo</label><br />
              <span class="btn btn-default btn-file">
                Browse <input type="file" id="photo" name="photo" />
              </span><br />
            </div>

            <button type="submit" class="btn btn-primary" name="Submit" id="send-member-form">
              Add the member
            </button>
          </form>
          <div id="added-ok" class="text-success" hidden>
            <h3>Successfully added member! Boom...</h3></div>
          <div id="add-failed" class="text-danger" hidden>
            <h3>Failed to add member!</h3>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
<hr />
