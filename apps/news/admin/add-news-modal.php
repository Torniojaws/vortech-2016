<div class="container-fluid">
    <div class="row text-center">
        <label for="news-btn">Admin - Add news</label><br />
        <button type="button" class="btn btn-primary" id="news-btn" data-toggle="modal" data-target="#news-form">Open Form</button>
    </div>

    <!-- Modal for news details -->
    <div class="modal fade" id="news-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add news</h4>
                </div>
                <div class="modal-body">
                    <!-- Add news -->
                    <form role="form" class="form" id="ad-news-form" name="add-news-form">

                        <div class="form-group">
                            <label for="title">News title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="News headline" />
                            <label for="text">News text</label>
                            <textarea class="form-control" rows="5" id="text" name="text" placeholder="Write your news here"></textarea>
                            <label for="tags">Tags for the news <small class="text-muted">(separate with comma)</small></label>
                            <input type="text" class="form-control" id="tags" name="tags" placeholder="Tag 1, Tag 2, Tag 3, ..." />
                        </div>

                        <button type="submit" class="btn btn-primary" name="Submit" id="send-news-form">Add the news</button>
                    </form>
                    <div id="added-ok" class="text-success" hidden><h3>Successfully added news! Boom...</h3></div>
                    <div id="add-failed" class="text-danger" hidden><h3>Failed to add news!</h3></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
<hr />
