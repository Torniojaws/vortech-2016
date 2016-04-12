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
            url: 'templates/forms/process-admin-form.php',
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
            url: 'templates/forms/process-admin-form.php',
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

    // Switching between adding a new album and using existing
    $('input[name=use-existing]').click(function () {
        $('.toHide').hide();
        $('#show' + $(this).val()).show('slow');
    });

    // Updates the Photo Albums list based on Category that was chosen
    $('#category').on('change', function () {
        var selected = $(this).val();
        $('#category-newalbum option').each(function () {
            var element = $(this);
            if (element.data('tag') !== selected) {
                element.hide();
                // This prevents the hidden field from being submitted in POST
                element.prop("disabled", true);
            } else {
                element.show();
            }
        });
        $('#selected-album option').each(function () {
            var element = $(this);
            if (element.data('tag') !== selected) {
                element.hide();
                // This prevents the hidden field from being submitted in POST
                element.prop("disabled", true);
            } else {
                element.show();
            }
        });

        $('#category-newalbum').val($('#category-newalbum option:visible:first').val());
        $('#selected-album').val($('#selected-album option:visible:first').val());
    });

    // Add release form
    $('#ad-release-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/forms/process-release-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#add-failed').hide();
                    $('#ad-release-form').each(function () {
                        this.reset();
                    });
                    $('#added-ok').removeAttr('hidden');
                    setTimeout(function () {
                        // Close modal window after 2 seconds upon success
                        $('#release-form').modal('hide');
                    }, 2000);
                    location.reload();
                } else if (data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add news form
    $('#ad-news-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/forms/process-news-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#add-failed').hide();
                    $('#ad-news-form').each(function () {
                        this.reset();
                    });
                    $('#added-ok').removeAttr('hidden');
                    $('#news-form').modal('hide');
                    location.reload();
                } else if (data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add show form
    $('#ad-liveshow-form').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'templates/forms/process-show-form.php',
            data: data,
            success: function (data) {
                if (data.status === 'success') {
                    $('#add-failed').hide();
                    $('#ad-liveshow-form').each(function () {
                        this.reset();
                    });
                    $('#added-ok').removeAttr('hidden');
                    $('#liveshow-form').modal('hide');
                    location.reload();
                } else if (data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add photos form
    $('#ad-photos-form').submit(function (e) {
        e.preventDefault();
        var form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'templates/forms/process-photos-form.php',
            cache: false,
            data: form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#photos-form').modal('hide');
                    location.reload();
                } else if (data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

});
