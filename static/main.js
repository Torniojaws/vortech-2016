'use strict';
$(document).ready(function () {

    // Submit a new paste
    $('#ad-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        console.log(data);
        $.ajax({
            type: 'post',
            url: 'templates/process-admin-form.php',
            data: data,
            success: function(data) {
                $('#ad-form').each(function () {
                    this.reset();
                    $('.notification').removeAttr('hidden').fadeOut(4000);
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    });

    // Check if user has marked an entry
    $('.btn-mark').click(function (e) {
        e.preventDefault();
        console.log("User has marked item:");
        console.log(this.id);
        var current_id = this.id;
        $.ajax({
            type: 'post',
            url: 'functions/mark-item.php',
            data: {"id": current_id},
            success: function() {
                var item = $('#'+current_id);
                if (item.text() == 'Mark') {
                    item.fadeIn(500).text("Unmark");
                } else {
                    item.fadeIn(500).text("Mark");
                }
            }
        });
    });
});
