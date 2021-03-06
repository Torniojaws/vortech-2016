DROP DATABASE tech0;
CREATE USER 'teejii'@'localhost' IDENTIFIED BY 'samppeli';
GRANT ALL ON tech0.* TO 'teejii'@'localhost';

CREATE DATABASE tech0;
USE tech0;

CREATE TABLE news(
    id int AUTO_INCREMENT,
    title varchar(255),
    contents text,
    posted datetime,
    author varchar(255),
    tags varchar(1000),
    PRIMARY KEY(id)
);
CREATE TABLE releases(
    id int AUTO_INCREMENT,
    title varchar(255),
    release_code varchar(10),
    release_date datetime,
    artist varchar(100),
    has_cd varchar(3),
    publish_date datetime,
    full varchar(200),
    thumbnail varchar(200),
    release_notes text,
    PRIMARY KEY(id)
);
CREATE TABLE songs(
    song_id int AUTO_INCREMENT,
    release_code varchar(10),
    release_song_id int,
    title varchar(255),
    duration time,
    PRIMARY KEY(song_id)
);
CREATE TABLE shows(
    id int AUTO_INCREMENT,
    show_date datetime,
    continent varchar(50),
    country varchar(100),
    city varchar(100),
    venue varchar(100),
    other_bands text,
    band_comments text,
    setlist text,
    performers text,
    PRIMARY KEY(id)
);
CREATE TABLE photo_categories(
    id int AUTO_INCREMENT,
    name varchar(200),
    name_id varchar(200),
    PRIMARY KEY(id)
);
CREATE TABLE photo_albums(
    id int AUTO_INCREMENT,
    category_id int,
    name varchar(200),
    description text,
    show_in_gallery boolean,
    PRIMARY KEY(id)
);
CREATE TABLE photos(
    id int AUTO_INCREMENT,
    album_id int,
    date_taken datetime,
    taken_by varchar(200),
    full varchar(200),
    thumbnail varchar(500),
    caption varchar(1000),
    user_id int,
    PRIMARY KEY(id)
);
CREATE TABLE photo_comments(
    id int AUTO_INCREMENT,
    photo_id int,
    photo_comment_id int,
    category_comment_subid int,
    comment varchar(200),
    author_id varchar(200),
    date_commented datetime,
    PRIMARY KEY(id)
);
CREATE TABLE users(
    id int AUTO_INCREMENT,
    name varchar(200),
    username varchar(200),
    password text,
    access_level_id int,
    caption varchar(60),
    PRIMARY KEY(id)
);
CREATE TABLE user_access_levels(
    id int AUTO_INCREMENT,
    description varchar(200),
    PRIMARY KEY(id)
);
CREATE TABLE performers(
    id int AUTO_INCREMENT,
    name varchar(200),
    type varchar(100),
    instrument varchar(100),
    started datetime,
    quit datetime,
    photo_id int,
    PRIMARY KEY(id)
);
CREATE TABLE videos(
    id int AUTO_INCREMENT,
    title varchar(200),
    url text,
    host varchar(200),
    duration time,
    thumbnail varchar(200),
    category_id int,
    PRIMARY KEY(id)
);
CREATE TABLE video_categories(
    id int AUTO_INCREMENT,
    name varchar(200),
    description varchar(500),
    PRIMARY KEY(id)
);
CREATE TABLE visitor_count(
    id int AUTO_INCREMENT,
    count int,
    PRIMARY KEY(id)
);
CREATE TABLE shop_items(
    id int AUTO_INCREMENT,
    category_id int,
    name varchar(200),
    album_id int,
    description text,
    price float,
    full text,
    thumbnail text,
    paypal_button text,
    paypal_link text,
    bandcamp_link text,
    amazon_link text,
    spotify_link text,
    deezer_link text,
    itunes_link text,
    PRIMARY KEY(id)
);
CREATE TABLE shop_categories(
    id int AUTO_INCREMENT,
    name_id varchar(200),
    title varchar(200),
    description text,
    PRIMARY KEY(id)
);
CREATE TABLE guestbook(
    id int AUTO_INCREMENT,
    poster_id int,
    name varchar(200),
    post varchar(2000),
    posted datetime,
    PRIMARY KEY(id)
);
CREATE TABLE news_comments(
    id int AUTO_INCREMENT,
    comment_subid int,
    news_id int,
    author varchar(200),
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE release_comments(
    id int AUTO_INCREMENT,
    comment_subid int,
    release_code varchar(10),
    author varchar(200),
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE guestbook_comments(
    id int AUTO_INCREMENT,
    comment_subid int UNIQUE,
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE show_comments(
    id int AUTO_INCREMENT,
    show_id int,
    comment_subid int,
    author varchar(200),
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE song_comments(
    id int AUTO_INCREMENT,
    song_id int,
    release_code varchar(10),
    comment_subid int,
    author varchar(200),
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE performer_comments(
    id int AUTO_INCREMENT,
    performer_id int,
    comment_subid int,
    author varchar(200),
    author_id int,
    comment text,
    posted datetime,
    PRIMARY KEY(id));
CREATE TABLE video_comments(
    id int AUTO_INCREMENT,
    video_id int,
    video_comment_id int,
    category_comment_subid int,
    comment varchar(200),
    author_id varchar(200),
    date_commented datetime,
    PRIMARY KEY(id)
);
CREATE TABLE shopitem_comments(
    id int AUTO_INCREMENT,
    shopitem_id int,
    shopitem_comment_id int,
    category_comment_subid int,
    comment varchar(200),
    author_id varchar(200),
    date_commented datetime,
    PRIMARY KEY(id)
);
CREATE TABLE articles(
    id int AUTO_INCREMENT,
    category varchar(100),
    short varchar(200),
    full text,
    subid int,
    PRIMARY KEY(id)
);
CREATE TABLE article_comments(
    id int AUTO_INCREMENT,
    article_id int,
    comment_subid int,
    comment varchar(200),
    author_id varchar(200),
    date_commented datetime,
    PRIMARY KEY(id)
);
CREATE TABLE antispam(
    id int AUTO_INCREMENT,
    question varchar(200),
    answer varchar(200),
    PRIMARY KEY(id)
);
CREATE TABLE votes(
    id int AUTO_INCREMENT,
    category varchar(200),
    item int,
    rating float,
    posted datetime,
    PRIMARY KEY(id)
);

INSERT INTO news VALUES(
    1,
    "News title",
    "News contents",
    "2016-01-01 00:00:00",
    "Juha",
    "Tag, Toinen"
);
INSERT INTO news VALUES(
    2,
    "Another news title",
    "More news contents",
    "2016-01-02 02:00:00",
    "Juha",
    "Tag, Test, Toinen"
);
INSERT INTO releases VALUES(1, "Debut Album", "CD001", "2010-04-04 00:00:00", "Artiste", "yes", "2010-04-04 00:00:00", "cd.jpg", "thumbnails/cd.jpg", "Release notes");
INSERT INTO releases VALUES(2, "Album 2: The Return", "CD002", "2012-04-05 00:00:00", "Artiste", "no", "2012-04-05 00:00:00", "cd.jpg", "thumbnails/cd.jpg", "Release notes");
INSERT INTO releases VALUES(3, "Album 3: Resurrection", "CD003", "2014-04-05 00:00:00", "Artiste", "yes", "2014-04-05 00:00:00", "cd.jpg", "thumbnails/cd.jpg", "Release notes");
INSERT INTO songs VALUES(1, "CD001", 1, "Song number 1", "00:03:16");
INSERT INTO songs VALUES(2, "CD001", 2, "Song number 2", "00:03:46");
INSERT INTO songs VALUES(3, "CD002", 1, "A new song", "00:06:16");
INSERT INTO songs VALUES(4, "CD003", 1, "Triple trouble", "00:04:26");
INSERT INTO songs VALUES(5, "CD003", 2, "Quadrouble", "00:04:56");
INSERT INTO shows VALUES(
    1,
    "2015-03-03 00:00:00",
    "Europe",
    "Finland",
    "Tornio",
    "Pikisaari",
    "Joku|www.testi.fi, Toinen|www.bandi.fi",
    "Nice show",
    "Eka|Toka|Kolmas",
    "Juha|Gtr, Mikko|Vox, Ville|Drums"
);
INSERT INTO shows VALUES(
    2,
    "2015-03-05 00:00:00",
    "Europe",
    "Finland",
    "Espoo",
    "Bodom",
    "Joku|www.testi.fi, Toinen|www.bandi.fi",
    "Nice show again",
    "Eka biisi|Toka|Kolmas",
    "Juha|Gtr, Mikko|Vox, Ville|Drums"
);
INSERT INTO photo_categories VALUES(1, "Promotional", "promo");
INSERT INTO photo_categories VALUES(2, "Studio", "studio");
INSERT INTO photo_categories VALUES(3, "Live", "live");
INSERT INTO photo_categories VALUES(4, "Misc", "misc");

INSERT INTO photo_albums VALUES(1, 1, "Promo pics from 2016", "All the promo pics taken during 2016", TRUE);
INSERT INTO photo_albums VALUES(2, 1, "Older promo pics", "Promo pics taken before 2016", TRUE);
INSERT INTO photo_albums VALUES(3, 2, "Studio 2016", "From the recording sessions of 2016", TRUE);
INSERT INTO photo_albums VALUES(4, 3, "Live shows from summer", "Pics throughout the summer tour", TRUE);
INSERT INTO photo_albums VALUES(5, 4, "Random stuff 15-16", "Interesting pics from 2015 and 2016", TRUE);

INSERT INTO photos VALUES(
    1, 4, "2015-06-04 00:00:00", "Juha", "image1.jpg", "thumbnails/image1.jpg", "Live stuff", NULL);
INSERT INTO photos VALUES(
    2, 4, "2015-06-07 00:00:00", "Juha", "image2.jpg", "thumbnails/image2.jpg", "More live", NULL);
INSERT INTO photos VALUES(
    3, 4, "2015-07-04 00:00:00", "Juha", "image3.jpg", "thumbnails/image3.jpg", "Seen performing", NULL);
INSERT INTO photos VALUES(
    4, 1, "2016-04-12 00:00:00", "Juha", "image4.jpg", "thumbnails/image4.jpg", "New promo pic!", NULL);
INSERT INTO photos VALUES(
    5, 2, "2013-04-01 00:00:00", "Juha", "image5.jpg", "thumbnails/image5.jpg", "Previous promo", NULL);
INSERT INTO photos VALUES(
    6, 3, "2016-03-22 00:00:00", "Juha", "image6.jpg", "thumbnails/image6.jpg", "Latest work in the studio!", NULL);
INSERT INTO photos VALUES(
    7, 3, "2016-09-30 00:00:00", "Juha", "image7.jpg", "thumbnails/image7.jpg", "Recording new stuff!", NULL);
INSERT INTO photos VALUES(
    8, 5, "2014-01-12 00:00:00", "Juha", "image8.jpg", "thumbnails/image8.jpg", "Strange pic", NULL);
INSERT INTO photos VALUES(
    9, 5, "2012-10-03 00:00:00", "Juha", "image9.jpg", "thumbnails/image9.jpg", "Random session with electronics", NULL);

/* The first four numbers are:

    Table index of the comment
    The ID (in table "photos") of the photo that the comment is for
    The index of the comment for a given photo, eg. if photo 1 has two comments, the first is 1 and second is 2
    The index of the comment for a given photo category, eg. if photo 1 is in category 1, and has three comments, they
        will be 1, 2, 3 -- kind of silly, though, TODO: Is there a use case for this?
*/
INSERT INTO photo_comments VALUES(1, 1, 1, 1, "Nice live picture", 3, "2016-03-18 00:00:00");
INSERT INTO photo_comments VALUES(2, 1, 2, 2, "Yeah! Live is nice", 3, "2016-03-18 01:00:00");
INSERT INTO photo_comments VALUES(3, 2, 1, 3, "Cool stuff live", 3, "2016-03-18 02:00:00");
INSERT INTO photo_comments VALUES(4, 2, 2, 4, "Live pictures are nice", 3, "2016-03-18 00:00:00");
INSERT INTO photo_comments VALUES(5, 3, 1, 5, "Yeah! Live indeed", 3, "2016-03-18 01:00:00");
INSERT INTO photo_comments VALUES(6, 3, 2, 6, "Finally live!", 3, "2016-03-18 02:00:00");
INSERT INTO photo_comments VALUES(7, 4, 1, 1, "Good promo pic", 3, "2016-03-18 00:00:00");
INSERT INTO photo_comments VALUES(8, 5, 1, 2, "Nice promo!", 3, "2016-03-18 01:00:00");
INSERT INTO photo_comments VALUES(9, 6, 1, 3, "Awesome promo picture!", 3, "2016-03-18 02:00:00");

INSERT INTO user_access_levels VALUES(1, "Administrator");
INSERT INTO user_access_levels VALUES(2, "Normal User");
INSERT INTO user_access_levels VALUES(3, "Guest");
INSERT INTO user_access_levels VALUES(4, "Blocked");

INSERT INTO performers VALUES(
    1, "Juha", "Founding member", "Guitar, Bass, Programming", "2000-01-01 00:00:00", "9999-12-12 23:59:59", 10);
INSERT INTO performers VALUES(
    2, "Tero", "Founding member", "Bass, Programming, Drums", "2000-01-01 00:00:00", "2004-10-12 23:59:59", 11);
INSERT INTO performers VALUES(
    3, "Matti", "Full member", "Vocals", "2007-11-01 00:00:00", "2011-12-12 23:59:59", 12);
INSERT INTO performers VALUES(
    4, "Ville", "Full member", "Drums", "2010-12-01 00:00:00", "9999-12-12 23:59:59", 13);
INSERT INTO performers VALUES(
    5, "Mikko", "Full member", "Vocals", "2012-03-01 00:00:00", "9999-12-12 23:59:59", 14);
INSERT INTO performers VALUES(
    6, "Samuli", "Live member", "Bass", "2001-10-01 00:00:00", "2001-11-22 23:59:59", 15);
INSERT INTO performers VALUES(
    7, "Rami", "Rehearsal member", "Drums", "2001-10-01 00:00:00", "2002-04-12 23:59:59", 16);
INSERT INTO performers VALUES(
    8, "Lukas", "Guest artist", "Vocals", "2007-03-01 00:00:00", "2007-04-12 23:59:59", 17);

INSERT INTO photo_categories VALUES(5, "Band members", "band_members");
INSERT INTO photo_albums VALUES(6, 5, "Band member pictures", "All the members of the band", FALSE);
INSERT INTO photos VALUES(
    10, 6, "2014-10-03 00:00:00", "Juha", "juha.jpg", "thumbnails/juha.jpg", "Juha 2014", NULL);
INSERT INTO photos VALUES(
    11, 6, "2014-10-03 00:00:00", "Tero", "tero.jpg", "thumbnails/tero.jpg", "Tero 2008", NULL);
INSERT INTO photos VALUES(
    12, 6, "2014-10-03 00:00:00", "Matti", "matti.jpg", "thumbnails/matti.jpg", "Matti 2010", NULL);
INSERT INTO photos VALUES(
    13, 6, "2014-10-03 00:00:00", "Ville", "ville.jpg", "thumbnails/ville.jpg", "Ville 2012", NULL);
INSERT INTO photos VALUES(
    14, 6, "2014-10-03 00:00:00", "Mikko", "mikko.jpg", "thumbnails/mikko.jpg", "Mikko 2014", NULL);
INSERT INTO photos VALUES(
    15, 6, "2014-10-03 00:00:00", "Samuli", "samuli.jpg", "thumbnails/samuli.jpg", "Samuli 2001", NULL);
INSERT INTO photos VALUES(
    16, 6, "2014-10-03 00:00:00", "Rami", "rami.jpg", "thumbnails/rami.jpg", "Rami 2008", NULL);
INSERT INTO photos VALUES(
    17, 6, "2014-10-03 00:00:00", "Lukas", "lukas.jpg", "thumbnails/lukas.jpg", "Lukas 2007", NULL);

INSERT INTO video_categories VALUES(1, "Live", "Videos from our live performances");
INSERT INTO video_categories VALUES(2, "Studio", "Studio videos from various recording sessions");
INSERT INTO video_categories VALUES(3, "Music videos", "Official music videos");
INSERT INTO video_categories VALUES(4, "Album videos", "Full album videos");
INSERT INTO videos VALUES(1, "The Live in Oulu", "http://www.vimeo.com/vortech", "Vimeo", "00:25:00",
    "videos/thumbnails/oulu2009.jpg", 1);
INSERT INTO videos VALUES(2, "Recording the album Of What Remains", "http://www.youtube.com/vortech", "Youtube",
    "00:10:00", "videos/thumbnails/owr-studio.jpg", 2);
INSERT INTO videos VALUES(3, "Disconnect (music video)", "http://www.vimeo.com/vortech", "Vimeo", "00:04:00",
    "videos/thumbnails/disconnect.jpg", 3);
INSERT INTO videos VALUES(4, "Devoid of Life (2016) - full album video", "http://www.vimeo.com/vortech", "Vimeo",
    "00:38:00", "videos/thumbnails/devoid-full.jpg", 4);
INSERT INTO videos VALUES(5, "The Occlusion (2014) - full album video", "http://www.vimeo.com/vortech", "Vimeo",
    "00:45:00", "videos/thumbnails/occlusion-full.jpg", 4);
INSERT INTO videos VALUES(6, "Random studio stuff", "http://www.vimeo.com/vortech", "Vimeo", "00:12:00",
    "videos/thumbnails/rand-studio.jpg", 2);

INSERT INTO visitor_count VALUES(1, 873227);

INSERT INTO shop_categories VALUES(1, "merch", "Merchandise", "Get your shirts and other things here!");
INSERT INTO shop_categories VALUES(2, "cd", "CDs", "Get your shirts and other things here!");
INSERT INTO shop_categories VALUES(3, "digital", "Digital releases", "Get your shirts and other things here!");
INSERT INTO shop_items VALUES(1, 1, "T-shirt 2009", 0, "Very nice thingy!", 123.45, "shop-shirt2009.jpg",
    "thumbnails/shop-shirt2009.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(2, 2, "CD - Of What Remains", 1, "Latest album from us!", 12.99, "cd-owr.jpg",
    "thumbnails/cd-owr.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(3, 3, "Digital - Of What Remains", 1, "New digital album", 5.99, "digi-owr.jpg",
    "thumbnails/digi-owr.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(4, 2, "CD - Occlusion", 2, "Get some electronic stuff", 12.45, "cd-occ.jpg",
    "thumbnails/cd-occ.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(5, 2, "CD - Devoid", 3, "Live drumming on this album!", 7.45, "digi-devoid.jpg",
    "thumbnails/digi-devoid.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(6, 3, "Digital - Occlusion", 2, "Electronic in electronic format - yeah baby!", 4.45,
    "digi-occ.jpg", "thumbnails/digi-occ.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");
INSERT INTO shop_items VALUES(7, 1, "T-shirt 2012", 0, "Get that cold and riveted feeling inside", 23.45,
    "shop-shirt2012.jpg", "thumbnails/shop-shirt2012.jpg", "PayBal button", "http://www.paypal.com",
    "http://vortech.bandcamp.com", "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com",
    "http://www.itunes.com");
INSERT INTO shop_items VALUES(8, 3, "Digital - Devoid", 3, "Music for the empty world", 3.45, "digi-devoid.jpg",
    "thumbnails/digi-devoid.jpg", "PayBal button", "http://www.paypal.com", "http://vortech.bandcamp.com",
    "http://www.amazon.com", "http://www.spotify.com", "http://www.deezer.com", "http://www.itunes.com");

INSERT INTO guestbook VALUES(1, 2, "Guest with a name", "This is a very nice thing!", "2016-03-29 09:53:00");
INSERT INTO guestbook VALUES(2, 2, "Another guest with a name", "Very nice indeed!", "2016-03-29 09:54:00");
INSERT INTO guestbook VALUES(3, 3, "From a logged in user", "Nice post is right here.", "2016-03-29 09:55:00");
INSERT INTO guestbook VALUES(4, 4, "This is a blocked user", "Did I perhaps post some spam?", "2016-03-29 09:56:00");
INSERT INTO guestbook VALUES(5, 3, "Logging in", "From Canada, eh?", "2016-03-29 09:57:00");

INSERT INTO guestbook_comments VALUES(1, 1, 1, "Yes indeed!", "2016-03-29 09:58:00");
INSERT INTO guestbook_comments VALUES(2, 3, 1, "Welcome to Finland", "2016-03-29 09:59:00");
INSERT INTO guestbook_comments VALUES(3, 4, 1, "Shame on maple leaf", "2016-03-29 10:00:00");

INSERT INTO photo_categories VALUES(6, "User avatars", "user_photos");
INSERT INTO photo_albums VALUES(7, 6, "User-uploaded avatars", "All the user avatars uploaded by users", "FALSE");
INSERT INTO photos VALUES(18, 7, "2016-03-29 10:47:00", "Admin", "admin.jpg", "thumbnails/admin.jpg", "Administrator", 1);
INSERT INTO photos VALUES(19, 7, "2016-03-29 10:55:00", "Guest", "guest.jpg", "thumbnails/guest.jpg", "Guest", 2);
INSERT INTO photos VALUES(20, 7, "2016-03-29 10:55:00", "Regular Joe", "regular-joe.jpg", "thumbnails/regular-joe.jpg",
    "Regular Joe", 3);
INSERT INTO photos VALUES(21, 7, "2016-03-29 10:55:00", "Blocked User", "blocked-user.jpg",
    "thumbnails/blocked-user.jpg", "Blocked User", 4);

INSERT INTO show_comments VALUES(1, 1, 1, "Regular Joe", 3, "That was a great show!", "2016-03-30 16:34:00");
INSERT INTO show_comments VALUES(2, 2, 1, "Regular Joe", 3, "Another great show!", "2016-03-30 16:35:00");
INSERT INTO show_comments VALUES(3, 2, 2, "Visithor", 2, "It was nice to see it live!", "2016-03-29 02:00:00");

INSERT INTO song_comments VALUES(1, 1, "CD001", 1, "Jepss", 3, "Very nice song this one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(2, 1, "CD001", 2, "Onse", 2, "Tosi nice song one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(3, 2, "CD002", 1, "Kommentmän", 3, "Hyvin nice song this one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(4, 2, "CD002", 2, "Jeah", 3, "Very nice song this one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(5, 3, "CD003", 1, "Nimi", 2, "Kiva nice song this one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(6, 3, "CD003", 2, "On", 2, "Very nice song this one!", "2016-03-31 15:16:00");
INSERT INTO song_comments VALUES(7, 3, "CD003", 3, "Enne", 3, "Kova nice song this one!", "2016-03-31 15:16:00");

INSERT INTO performer_comments VALUES(1, 1, 1, "Testimies", 3, "Very nice playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(2, 1, 2, "Comment Man", 3, "Tosi nice playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(3, 2, 1, "Jokuman", 3, "Really nice playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(4, 2, 2, "Kommentoija", 3, "Extremely nice playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(5, 3, 1, "Skitta", 3, "Awesome playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(6, 4, 1, "Joomies", 3, "Killer playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(7, 5, 1, "Jokukommentoi", 3, "Brilliant playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(8, 5, 2, "Nimi on", 3, "Stunning playing!", "2016-04-01 15:04:00");
INSERT INTO performer_comments VALUES(9, 6, 1, "Enne", 3, "Outstandingly nice playing!", "2016-04-01 15:04:00");

/* The first four numbers are:

    Table index of the comment
    The ID (in table "videos") of the video that the comment is for
    The index of the comment for a given video, eg. if video 1 has two comments, the first is 1 and second is 2
    The index of the comment for a given video category, eg. if video 1 is in category 1, and has three comments, they
        will be 1, 2, 3 -- kind of silly, though, TODO: Is there a use case for this?
*/
INSERT INTO video_comments VALUES(1, 1, 1, 1, "Nice live video", 3, "2016-04-03 00:00:00");
INSERT INTO video_comments VALUES(2, 1, 2, 2, "Yeah! Video is nice", 3, "2016-04-18 01:00:00");
INSERT INTO video_comments VALUES(3, 2, 1, 3, "Cool video live", 3, "2016-04-18 02:00:00");
INSERT INTO video_comments VALUES(4, 2, 2, 4, "Live videos are nice", 3, "2016-04-18 00:00:00");
INSERT INTO video_comments VALUES(5, 3, 1, 5, "Yeah! Live indeed", 3, "2016-04-18 01:00:00");
INSERT INTO video_comments VALUES(6, 3, 2, 6, "Finally video!", 3, "2016-04-18 02:00:00");
INSERT INTO video_comments VALUES(7, 4, 1, 1, "Good promo video", 3, "2016-04-18 00:00:00");
INSERT INTO video_comments VALUES(8, 5, 1, 2, "Nice video!", 3, "2016-04-18 01:00:00");
INSERT INTO video_comments VALUES(9, 6, 1, 3, "Awesome promo video!", 3, "2016-04-18 02:00:00");

INSERT INTO news_comments VALUES(1, 1, 1, "Testimies", "Very nice to hear!", "2016-04-03 18:11:00");
INSERT INTO news_comments VALUES(2, 2, 1, "Jokuman", "Awesome!", "2016-04-03 18:12:00");
INSERT INTO news_comments VALUES(3, 1, 2, "Kommentoija", "Good to see!", "2016-04-03 18:13:00");
INSERT INTO news_comments VALUES(4, 2, 2, "Enne", "Looking forward!", "2016-04-03 18:14:00");
INSERT INTO news_comments VALUES(5, 3, 2, "Kommenthor", "Well done", "2016-04-03 18:15:00");
INSERT INTO news_comments VALUES(6, 4, 2, "Jess", "Jeah", "2016-04-03 18:16:00");

INSERT INTO release_comments VALUES(1, 1, "CD001", "Tekstaaja", "Very nice album!", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(2, 1, "CD002", "Jokuman", "Awesome release!", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(3, 1, "CD003", "Kommentoija", "Kickass", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(4, 2, "CD001", "Enne", "My favourite", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(5, 2, "CD002", "Skitta", "Tight stuff!", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(6, 3, "CD001", "Testimies", "Nice album!", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(7, 3, "CD002", "Kommenthor", "Very good album!", "2016-04-03 22:55:00");
INSERT INTO release_comments VALUES(8, 2, "CD003", "Kommentman", "Great nice album!", "2016-04-03 22:55:00");

/* The first four numbers are:

    Table index of the comment
    The ID (in table "shopitems") of the item that the comment is for
    The index of the comment for a given shopitem, eg. if shopitem 1 has two comments, the first is 1 and second is 2
    The index of the comment for a given shopitem category, eg. if shopitem 1 is in category 1, and has three comments, they
        will be 1, 2, 3 -- kind of silly, though, TODO: Is there a use case for this?
*/
INSERT INTO shopitem_comments VALUES(1, 1, 1, 1, "Very nice shirt!", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(2, 1, 2, 2, "Cool shirt!", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(3, 2, 1, 1, "Very nice CD", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(4, 2, 2, 2, "Awesome CD!", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(5, 3, 1, 1, "Very nice quality download", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(6, 4, 1, 3, "Very good album!", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(7, 4, 2, 4, "So nice album!", 3, "2016-04-04 00:27:00");
INSERT INTO shopitem_comments VALUES(8, 4, 3, 5, "Excellent release!", 3, "2016-04-04 00:27:00");

INSERT INTO articles VALUES(
    0,
    "biography",
    "Short bio for the band",
    "This will be the long biography for the band. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    1
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Started playing guitar in 1997 and wrote songs from 2000 on",
    "This will be the long article of Juha in bio. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    1
);
INSERT INTO articles VALUES(
    0,
    "main",
    "Short text for the main page description",
    "This will be the long text for the main page. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    1
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Drummer, bass player and co-songwriter from the beginning",
    "This will be the long article of Tero. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    2
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Joined on vocals after Wasteland and was in all live shows",
    "This will be the long article of Matti S. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    3
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Drumming since 2010 and first live drums on any of our albums with Devoid of Life",
    "This will be the long article of Ville. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    4
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Joined on vocals after the nice performance on Devoid of Life",
    "This will be the long article of Mikko N. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    5
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Helped us out in our very first live performance",
    "This will be the long article of Samuli. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    6
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Played rehearsal drums for us for a good bit of time",
    "This will be the long article of Rami. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    7
);
INSERT INTO articles VALUES(
    0,
    "members",
    "Did some awesome guest vocals on The Core, from the album Wasteland",
    "This will be the long article of Lukas. Use markdown like [p], [b], [url=link]name[/url] to add paragraphs etc.",
    8
);

INSERT INTO article_comments VALUES(0, 1, 1, "Very nice to read all that info!", 3, "2016-04-20 10:30:00");
INSERT INTO article_comments VALUES(0, 1, 2, "Cool details!", 3, "2016-04-20 10:31:00");
INSERT INTO article_comments VALUES(0, 1, 3, "Interesting stuff!", 3, "2016-04-20 10:32:00");
INSERT INTO article_comments VALUES(0, 2, 1, "Very nice to find that out!", 3, "2016-04-20 10:33:00");
INSERT INTO article_comments VALUES(0, 2, 2, "Oh yeah!", 3, "2016-04-20 10:34:00");
INSERT INTO article_comments VALUES(0, 3, 1, "Nice intro!", 3, "2016-04-20 10:35:00");
INSERT INTO article_comments VALUES(0, 3, 2, "Excellent stuff!", 3, "2016-04-20 10:36:00");

INSERT INTO antispam VALUES(0, "One, Two, _____, Four", "Three");
INSERT INTO antispam VALUES(0, "1 + 3 = _", "4");
INSERT INTO antispam VALUES(0, "Death _____, Industrial _____, Heavy _____", "Metal");
INSERT INTO antispam VALUES(0, "If you are human, write <strong>yes</strong>", "yes");

INSERT INTO votes VALUES(0, "releases", 1, 3.5, "2016-05-11 11:12:00");
INSERT INTO votes VALUES(0, "releases", 1, 4, "2016-05-11 11:13:00");
INSERT INTO votes VALUES(0, "releases", 2, 3, "2016-05-11 11:14:00");
INSERT INTO votes VALUES(0, "releases", 2, 3, "2016-05-11 11:15:00");
INSERT INTO votes VALUES(0, "releases", 2, 4.5, "2016-05-11 11:16:00");
INSERT INTO votes VALUES(0, "releases", 3, 5, "2016-05-11 11:17:00");
INSERT INTO votes VALUES(0, "releases", 3, 2, "2016-05-11 11:18:00");

INSERT INTO votes VALUES(0, "songs", 1, 2.5, "2016-05-11 11:19:01");
INSERT INTO votes VALUES(0, "songs", 1, 3.5, "2016-05-11 11:19:02");
INSERT INTO votes VALUES(0, "songs", 2, 4, "2016-05-11 11:19:03");
INSERT INTO votes VALUES(0, "songs", 1, 3, "2016-05-11 11:19:04");
INSERT INTO votes VALUES(0, "songs", 3, 4.5, "2016-05-11 11:19:05");
INSERT INTO votes VALUES(0, "songs", 3, 5, "2016-05-11 11:19:06");
INSERT INTO votes VALUES(0, "songs", 1, 2.5, "2016-05-11 11:19:07");
INSERT INTO votes VALUES(0, "songs", 2, 2.5, "2016-05-11 11:19:08");
INSERT INTO votes VALUES(0, "songs", 1, 3.5, "2016-05-11 11:19:09");
INSERT INTO votes VALUES(0, "songs", 5, 4.5, "2016-05-11 11:19:10");
INSERT INTO votes VALUES(0, "songs", 4, 3.5, "2016-05-11 11:19:20");
INSERT INTO votes VALUES(0, "songs", 4, 1.5, "2016-05-11 11:19:30");
INSERT INTO votes VALUES(0, "songs", 3, 2.5, "2016-05-11 11:19:40");
INSERT INTO votes VALUES(0, "songs", 1, 3.5, "2016-05-11 11:19:50");
INSERT INTO votes VALUES(0, "songs", 1, 5.5, "2016-05-11 11:19:55");
INSERT INTO votes VALUES(0, "songs", 2, 4.5, "2016-05-11 11:20:00");
INSERT INTO votes VALUES(0, "songs", 1, 3.5, "2016-05-11 11:29:01");
INSERT INTO votes VALUES(0, "songs", 3, 2.5, "2016-05-11 11:29:02");
INSERT INTO votes VALUES(0, "songs", 1, 2.5, "2016-05-11 11:29:03");
INSERT INTO votes VALUES(0, "songs", 5, 3.5, "2016-05-11 11:29:04");

INSERT INTO votes VALUES(0, "photos", 1, 4, "2016-05-11 11:18:01");
INSERT INTO votes VALUES(0, "photos", 2, 3, "2016-05-11 11:18:02");
INSERT INTO votes VALUES(0, "photos", 3, 4.5, "2016-05-11 11:18:03");
INSERT INTO votes VALUES(0, "photos", 4, 5, "2016-05-11 11:18:04");
INSERT INTO votes VALUES(0, "photos", 3, 3, "2016-05-11 11:18:05");
INSERT INTO votes VALUES(0, "photos", 2, 2, "2016-05-11 11:18:06");
INSERT INTO votes VALUES(0, "photos", 1, 4.5, "2016-05-11 11:18:07");
INSERT INTO votes VALUES(0, "photos", 4, 3, "2016-05-11 11:18:08");
INSERT INTO votes VALUES(0, "photos", 5, 3.5, "2016-05-11 11:18:09");
INSERT INTO votes VALUES(0, "photos", 6, 2, "2016-05-11 11:18:10");
