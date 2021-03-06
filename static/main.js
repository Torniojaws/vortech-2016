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
            url: 'apps/admin/forms/admin.php',
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
                    if (data.message === 'Unauthorized') {
                        $('#login-unauthorized').removeAttr('hidden');
                    } else {
                        $('#login-failed').removeAttr('hidden');
                    }
                }
            },
            error: function (login_error) {
                if (login_error.message === 'Unauthorized') {
                    $('#login-unauthorized').removeAttr('hidden');
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
            url: 'apps/admin/forms/admin.php',
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

    // User login
    $('#login-form').submit(function (e) {
        e.preventDefault();
        var user_form_data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'apps/main/forms/user-login.php',
            data: user_form_data,
            success: function (user_data) {
                if (user_data.status === 'success') {
                    $('#login-failed').hide();
                    $('#login-form').each(function () {
                        this.reset();
                    });
                    $('#login-ok').removeAttr('hidden').fadeOut(2000);
                    location.reload();
                } else if (user_data.status === 'error') {
                    $('#login-failed').removeAttr('hidden');
                }
            }
        });
    });

    // User logout
    $('#user-logout-form').submit(function (e) {
        e.preventDefault();
        var user_logout_data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: 'apps/main/forms/user-login.php',
            data: user_logout_data,
            success: function (user_logout_result_data) {
                if (user_logout_result_data.status === 'success') {
                    $('#logout-failed').hide();
                    $('#logout-form').each(function () {
                        this.reset();
                    });
                    $('#logout-ok').removeAttr('hidden').fadeOut(2000);
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else if (user_logout_result_data.status === 'error') {
                    $('#logout-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Switching between adding a new album and using existing
    $('input[name=use-existing]').click(function () {
        $('.toHide').hide();
        $('#show' + $(this).val()).show('slow');
        $('#category').trigger('change');

        // When creating a new album, hide the select related to it
        // It submits the ID of the category, while the top-most select
        // sends the name_id of the category. Both are needed.
        $('#category-newalbum').hide();
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
                element.prop("disabled", false);
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
                element.prop("disabled", false);
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
            url: 'apps/releases/admin/add-release.php',
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
            url: 'apps/news/admin/add-news.php',
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
            url: 'apps/shows/admin/add-show.php',
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
        var photo_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/photos/admin/add-photos.php',
            cache: false,
            data: photo_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (photo_data) {
                if (photo_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#photos-form').modal('hide');
                    location.reload();
                } else if (photo_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add video form
    $('#ad-video-form').submit(function (e) {
        e.preventDefault();
        var video_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/videos/admin/add-video.php',
            cache: false,
            data: video_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (video_data) {
                if (video_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#video-form').modal('hide');
                    location.reload();
                } else if (video_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Shows album selection field when adding a CD or Digital Album, otherwise hidden,
    // and also shows photo upload field when not adding a CD or digital album
    $('select[name=shop-category]').on('change', function () {
        var shop_category = parseInt($(this).val(), 10);
        // 2 = CD, 3 = Digital album
        if (shop_category === 2 || shop_category === 3) {
            $('#release').show('slow');
            $('#shop-photo').hide('slow');
        } else {
            $('.toHide').hide('slow');
            $('#shop-photo').show('slow');
        }
    });

    // Add shop item form
    $('#ad-shopitem-form').submit(function (e) {
        e.preventDefault();
        var shop_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/shop/admin/add-shopitem.php',
            cache: false,
            data: shop_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (shop_data) {
                if (shop_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#shop-form').modal('hide');
                    location.reload();
                } else if (shop_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add guestbook comment form
    $('[id^=ad-guestbook-comment-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'apps/guestbook/admin/add-comment.php',
            data: $(this).serialize(),
            success: function (gb_data) {
                if (gb_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#ad-guestbook-comment-form').each(function () {
                        this.reset();
                    });
                    $('#added-ok').removeAttr('hidden');
                    $('#guestbook-comment-form').modal('hide');
                    location.reload();
                } else if (gb_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Add member form
    $('#ad-member-form').submit(function (e) {
        e.preventDefault();
        var member_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/bio/admin/add-member.php',
            cache: false,
            data: member_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (member_data) {
                if (member_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#member-form').modal('hide');
                    location.reload();
                } else if (member_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Edit show form
    $('[id^=ad-edit-show]').submit(function (e) {
        e.preventDefault();
        var editshow_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/shows/edit/show.php',
            cache: false,
            data: editshow_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (editshow_data) {
                if (editshow_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('[id^=edit-show]').modal('hide');
                    location.reload();
                } else if (editshow_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // User register form
    $('#register-form').submit(function (e) {
        e.preventDefault();
        var register_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/main/forms/register-user.php',
            cache: false,
            data: register_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (register_data) {
                if (register_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#register-form').modal('hide');
                    location.reload();
                } else if (register_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Edit profile form
    $('#profile-form').submit(function (e) {
        e.preventDefault();
        var profile_form_data = new FormData($(this)[0]);
        $.ajax({
            type: 'post',
            url: 'apps/profile/edit/profile.php',
            cache: false,
            data: profile_form_data,
            async: false,
            processData: false,
            contentType: false,
            success: function (profile_data) {
                if (profile_data.status === 'success') {
                    $('#add-failed').hide();
                    $('#added-ok').removeAttr('hidden');
                    $('#profile-form').modal('hide');
                    location.reload();
                } else if (profile_data.status === 'logout') {
                    // A logout is forced when username or password is changed
                    $.ajax({
                        type: 'post',
                        url: 'apps/main/forms/user-login.php',
                        data: {
                            'userLogout': true,
                        },
                        success: function () {
                            location.reload();
                        }
                    });
                } else if (profile_data.status === 'error') {
                    $('#add-failed').removeAttr('hidden');
                }
            }
        });
    });

    // Edit news (admin)
    $('.edit-news').editable('apps/news/edit/news.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...'
    });
    $('.edit-news-area').editable('apps/news/edit/news.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit guestbook comment (admin)
    $('.edit-gb').editable('apps/guestbook/edit/guestbook.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...'
    });
    $('.edit-gb-area').editable('apps/guestbook/edit/guestbook.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit shop items (admin)
    $('.edit-shop').editable('apps/shop/edit/shop.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: "display: inline"
    });
    $('.edit-shop-area').editable('apps/shop/edit/shop.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit videos (admin)
    $('.edit-video').editable('apps/videos/edit/video.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: "display: inline"
    });
    $('.edit-video-area').editable('apps/videos/edit/video.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit biography text (admin)
    $('.edit-bio').editable('apps/bio/edit/bio.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...'
    });
    $('.edit-bio-area').editable('apps/bio/edit/bio.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit member bio text (admin)
    $('.edit-memberbio').editable('apps/bio/edit/member.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...'
    });
    $('.edit-memberbio-area').editable('apps/bio/edit/member.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit release text (admin)
    $('.edit-release').editable('apps/releases/edit/release.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: 'display: inline'
    });
    $('.edit-release-area').editable('apps/releases/edit/release.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...',
        style: 'inherit'
    });

    // Edit song text (admin)
    $('.edit-song').editable('apps/releases/edit/song.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: 'display: inline'
    });
    $('.edit-song-area').editable('apps/releases/edit/song.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit photo caption (admin)
    $('.edit-photo').editable('apps/photos/edit/photo.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: 'display: inline'
    });
    $('.edit-photo-area').editable('apps/photos/edit/photo.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });

    // Edit landing page article (admin)
    $('.edit-landing').editable('apps/main/edit/landing.php', {
        indicator: 'Saving...',
        tooltip: 'Click to edit...',
        style: 'display: inline'
    });
    $('.edit-landing-area').editable('apps/main/edit/landing.php', {
        type: 'textarea',
        submit: 'OK',
        cancel: 'Cancel',
        indicator: 'indicator',
        tooltip: 'Click to edit...'
    });
});

// User comment in News section
$('[id^=user-news-comment]').submit(function (e) {
    e.preventDefault();
    var news_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/news/forms/add-user-comment.php',
        cache: false,
        data: news_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (nc_data) {
            console.log(nc_data);
            if (nc_data.status === 'success') {
                $('#add-failed-' + nc_data.modal_id).hide();
                $('#added-ok-' + nc_data.modal_id).removeAttr('hidden');
                // Reload contents of modal after successful add
                var target = "showModal=" + nc_data.modal_id;
                // If user adds multiple comments, this prevents duplicating the GET parameter in
                // the url, eg www.url.com/page?showModal=2?showModal=2?showModal=2
                if ((window.location.href).indexOf(target) > -1) {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.href + "?" + target;
                }
            } else if (nc_data.status === 'error') {
                $('#add-failed-' + nc_data.modal_id).removeAttr('hidden');
            }
        }
    });
});

// User comment in Releases section
$('[id^=user-release-comment]').submit(function (e) {
    e.preventDefault();
    var release_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/releases/forms/add-user-comment.php',
        cache: false,
        data: release_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (rc_data) {
            if (rc_data.status === 'success') {
                $('#add-failed-' + rc_data.release_code).hide();
                $('#added-ok-' + rc_data.release_code).removeAttr('hidden');
                // Reload contents of modal after successful add
                var target = "showModal=" + rc_data.modal_id;
                // If user adds multiple comments, this prevents duplicating the GET parameter in
                // the url, eg www.url.com/page?showModal=2?showModal=2?showModal=2
                if ((window.location.href).indexOf(target) > -1) {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.href + "?" + target;
                }
            } else if (rc_data.status === 'error') {
                $('#add-failed-' + rc_data.release_code).removeAttr('hidden');
            }
        }
    });
});

// User comment in Photos section
$('[id^=user-photo-comment]').submit(function (e) {
    e.preventDefault();
    var photo_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/photos/forms/add-user-comment.php',
        cache: false,
        data: photo_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (pc_data) {
            if (pc_data.status === 'success') {
                $('#add-failed-' + pc_data.modal_id).hide();
                $('#added-ok-' + pc_data.modal_id).removeAttr('hidden');
                // Reload contents of modal after successful add
                var target = "showModal=" + pc_data.modal_id;
                // If user adds multiple comments, this prevents duplicating the GET parameter in
                // the url, eg www.url.com/page?showModal=2?showModal=2?showModal=2
                if ((window.location.href).indexOf(target) > -1) {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.href + "?" + target;
                }
            } else if (pc_data.status === 'error') {
                $('#add-failed-' + pc_data.modal_id).removeAttr('hidden');
            }
        }
    });
});

// User comment in Bio section
$('[id^=user-bio-comment]').submit(function (e) {
    e.preventDefault();
    var bio_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/bio/forms/add-user-comment.php',
        cache: false,
        data: bio_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (bc_data) {
            if (bc_data.status === 'success') {
                $('#add-failed-' + bc_data.modal_id).hide();
                $('#added-ok-' + bc_data.modal_id).removeAttr('hidden');
                // Reload contents of modal after successful add
                var target = "showModal=" + bc_data.modal_id;
                // If user adds multiple comments, this prevents duplicating the GET parameter in
                // the url, eg www.url.com/page?showModal=2?showModal=2?showModal=2
                if ((window.location.href).indexOf(target) > -1) {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.href + "?" + target;
                }
            } else if (bc_data.status === 'error') {
                $('#add-failed-' + bc_data.modal_id).removeAttr('hidden');
            }
        }
    });
});

// User comment in Shop section
$('[id^=user-shop-comment]').submit(function (e) {
    e.preventDefault();
    var shop_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/shop/forms/add-user-comment.php',
        cache: false,
        data: shop_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (sc_data) {
            if (sc_data.status === 'success') {
                $('#add-failed-' + sc_data.modal_id).hide();
                $('#added-ok-' + sc_data.modal_id).removeAttr('hidden');
                // Reload contents of modal after successful add
                var target = "showModal=" + sc_data.modal_id;
                // If user adds multiple comments, this prevents duplicating the GET parameter in
                // the url, eg www.url.com/page?showModal=2?showModal=2?showModal=2
                if ((window.location.href).indexOf(target) > -1) {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.href + "?" + target;
                }
            } else if (bc_data.status === 'error') {
                $('#add-failed-' + sc_data.modal_id).removeAttr('hidden');
            }
        }
    });
});

// Guestbook comment
$('#user-guestbook-form').submit(function (e) {
    e.preventDefault();
    var guestbook_comment_data = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url: 'apps/guestbook/forms/add-guestbook-post.php',
        cache: false,
        data: guestbook_comment_data,
        async: false,
        processData: false,
        contentType: false,
        success: function (gb_data) {
            if (gb_data.status === 'success') {
                $('#add-failed').hide();
                $('#added-ok').removeAttr('hidden');
                // Reload contents of modal after successful add
                location.reload();
            } else if (gb_data.status === 'error') {
                $('#add-failed').removeAttr('hidden');
            }
        },
        // This will catch HTTP 400 status errors
        error: function (gb_other_errors) {
            var gb_errors = JSON.parse(gb_other_errors.responseText);
            $('#add-failed').removeAttr('hidden').append(
                '<h3>' + gb_errors.message + '</h3>'
            );
        }
    });
});

// Releases rating
$('[id^=releases-rating]').on('rating.change', function (e, value) {
    e.preventDefault();
    // We assume that the id is in format "release-rating-4"
    console.log('Release ID = ' + this.id.split('-')[2]);
    var that = this.id;
    console.log('User rated it: ' + value);
    // POST to API
    $.ajax({
        type: 'post',
        url: 'api/v1/votes/releases/' + this.id.split('-')[2],
        cache: false,
        data: 'rating=' + value,
        async: false,
        processData: false,
        contentType: false,
        success: function (rr_data) {
            console.log(that);
            console.log('User rating was added successfully');
            $('#added-ok-' + that.split('-')[2]).removeAttr('hidden').fadeOut(2000);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    });
});

// Song rating
$('[id^=songs-rating]').on('rating.change', function (e, value) {
    e.preventDefault();
    // We assume that the id is in format "song-rating-4"
    console.log('Song ID = ' + this.id.split('-')[2]);
    var that = this.id;
    console.log('User rated it: ' + value);
    // POST to API
    $.ajax({
        type: 'post',
        url: 'api/v1/votes/songs/' + this.id.split('-')[2],
        cache: false,
        data: 'rating=' + value,
        async: false,
        processData: false,
        contentType: false,
        success: function (sr_data) {
            console.log(that);
            console.log('User rating was added successfully');
            $('#added-ok-' + that.split('-')[2]).removeAttr('hidden').fadeOut(2000);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    });
});

// Photo rating
$('[id^=photos-rating]').on('rating.change', function (e, value) {
    e.preventDefault();
    // We assume that the id is in format "photo-rating-4"
    console.log('Photo ID = ' + this.id.split('-')[2]);
    var that = this.id;
    console.log('User rated it: ' + value);
    // POST to API
    $.ajax({
        type: 'post',
        url: 'api/v1/votes/photos/' + this.id.split('-')[2],
        cache: false,
        data: 'rating=' + value,
        async: false,
        processData: false,
        contentType: false,
        success: function (pr_data) {
            console.log(that);
            console.log('User rating was added successfully');
            $('#added-ok-' + that.split('-')[2]).removeAttr('hidden').fadeOut(2000);
            // Reload contents of modal after successful add
            var target = "showModal=" + that.split('-')[2];
            // If user opens another modal after voting on one Photo, this prevents
            // duplicating the GET parameter in the url,
            // eg www.url.com/page?showModal=2?showModal=3?showModal=4
            if ((window.location.href).indexOf(target) > -1) {
                window.location = window.location.href;
            } else {
                // Replace url.com/photos?showModal=1 with url.com/photos and
                // then append current param
                window.location = window.location.href.split('?')[0] + "?" + target;
            }
        }
    });
});
