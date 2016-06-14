<div class="container-fluid">
  <div class="row text-center">
    <label for="release-btn">Admin - Add new show</label><br />
    <button type="button" class="btn btn-primary" id="liveshow-btn" data-toggle="modal"
            data-target="#liveshow-form">Open Form</button>
  </div>

  <!-- Modal for liveshow details -->
  <div class="modal fade" id="liveshow-form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new show</h4>
        </div>
        <div class="modal-body">
          <!-- Add new liveshow -->
          <h4>New show details</h4>
          <form class="form" id="ad-liveshow-form" name="add-liveshow-form">
            <!-- Mandatory details -->
            <div class="form-group">
              <label for="artist">Show date</label>
              <input type="text" class="form-control" id="date" name="date"
                     placeholder="yyyy-mm-dd hh:mm:ss" />
              <label for="album">Continent</label>
              <input type="text" class="form-control" id="continent" name="continent"
                     placeholder="eg. Europe" />
              <label for="date">Country</label>
              <input type="text" class="form-control" id="country" name="country"
                     placeholder="eg. Finland" />
              <label for="date">City</label>
              <input type="text" class="form-control" id="city" name="city"
                     placeholder="eg. Helsinki" />
              <label for="date">Venue</label>
              <input type="text" class="form-control" id="venue" name="venue"
                     placeholder="eg. Tavastia" />
            </div>
            <!-- Additional details -->
            <label for="show-extra-details">Optional details (can be added later too)</label>
            <div class="form-group" id="show-extra-details">
              <label for="songs">Other bands
                <small class="text-muted">
                  One band and their website per row in format: [Band|http://www.band.fi]
                </small>
              </label>
              <textarea class="form-control" rows="5" id="other_bands" name="other_bands"
                        placeholder="Band|http://www.band.fi"></textarea>
              <label for="date">Band comments</label>
              <input type="text" class="form-control" id="band_comments" name="band_comments"
                     placeholder="eg. It was a great show" />

              <label for="setlist">Setlist
                <small class="text-muted">
                  List of songs performed at the show. One song per row.
                </small>
              </label>
              <textarea class="form-control" rows="5" id="setlist" name="setlist"
                        placeholder="Setlist"></textarea>

              <label for="performers">Performers
                <small class="text-muted">
                  List of performers at the show - one performer per row. Pipe-separate the
                  instrument (Name|instrument)
                </small>
              </label>
              <textarea class="form-control" rows="5" id="performers" name="performers"
                        placeholder="Name|Instrument, Name|Instrument"></textarea>

            </div>
            <button type="submit" class="btn btn-primary" name="Submit" id="send-liveshow-form">
              Add the show
            </button>
          </form>
          <div id="added-ok" class="text-success" hidden>
            <h3>Successfully added show! Boom...</h3>
          </div>
          <div id="add-failed" class="text-danger" hidden><h3>Failed to add show!</h3></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
<hr />
