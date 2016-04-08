/*jslint node: true */
/*jslint browser: true*/
/*global $, jQuery, alert*/
'use strict';

$(document).ready(function () {

    // Admin login
    $('#ad-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/process-admin-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#login-failed').hide();
                    $('#ad-form').each(function () {
                        this.reset();
                    });
                    $('#login-ok').removeAttr('hidden').fadeOut(2000);
                    location.reload();
                } else if (data.status === 'error') {
                    $('#login-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Admin logout
    $('#ad-logout-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/process-admin-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#logout-failed').hide();
                    $('#ad-logout-form').each(function () {
                        this.reset();
                    });
                    $('#logout-ok').removeAttr('hidden').fadeOut(2000);
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else if (data.status === 'error') {
                    $('#logout-failed').removeAttr('hidden');
                }
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
            success: function () {
                var item = $('#' + current_id);
                if (item.text() === 'Mark') {
                    item.fadeIn(500).text("Unmark");
                } else {
                    item.fadeIn(500).text("Mark");
                }
            }
        });
    });

    // Add release form
    $('#ad-release-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/process-release-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').each(function () {
                        this.reset();
                    });
                    $('#added-ok').removeAttr('hidden').fadeOut(2000);
                    setTimeout(function () {
                        // Close modal window after 2 seconds upon success
                        $('#release-form').modal('hide');
                    }, 2000);
                } else if (data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

});
