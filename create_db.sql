CREATE DATABASE tech0;
USE tech0;
CREATE TABLE news(id int, title varchar(255), contents text, posted datetime, author varchar(255), tags varchar(1000), PRIMARY KEY(id));
CREATE TABLE releases(id int, title varchar(255), release_code varchar(10), release_date datetime, artist varchar(100), has_cd varchar(3), PRIMARY KEY(id));
CREATE TABLE songs(song_id int, release_id int, release_song_id int, title varchar(255), duration time, PRIMARY KEY(song_id));
CREATE TABLE shows(id int, show_date datetime, continent varchar(50), country varchar(100), city varchar(100), venue varchar(100), other_bands text, band_comments text, setlist text, performers text, PRIMARY KEY(id));
CREATE TABLE photo_categories(id int, name varchar(200), name_id varchar(200), PRIMARY KEY(id));
CREATE TABLE photo_albums(id int, category_id int, name varchar(200), description text, PRIMARY KEY(id));
CREATE TABLE photos(id int, album_id int, date_taken datetime, taken_by varchar(200), full varchar(200), thumbnail varchar(500), caption varchar(1000), PRIMARY KEY(id));
CREATE TABLE photo_comments(id int, photo_id int, photo_comment_id int, comment varchar(200), author_id varchar(200), date_commented datetime, PRIMARY KEY(id));
CREATE TABLE users(id int, name varchar(200), username varchar(200), password text, access_level_id int, PRIMARY KEY(id));
CREATE TABLE user_access_levels(id int, description varchar(200), PRIMARY KEY(id));

CREATE TABLE news_comments(id int, comment_subid int, news_id int, author varchar(200), comment text, posted datetime, PRIMARY KEY(id));
CREATE TABLE release_comments(id int, comment_subid int, release_id int, author varchar(200), comment text, posted datetime, PRIMARY KEY(id));

INSERT INTO news VALUES(1, "News title", "News contents", "2016-01-01 00:00:00", "Juha", "Tag, Toinen");
INSERT INTO news VALUES(2, "Another news title", "More news contents", "2016-01-02 02:00:00", "Juha", "Tag, Test, Toinen");
INSERT INTO releases VALUES(1, "Debut Album", "CD001", "2010-04-04 00:00:00", "Artiste", "yes");
INSERT INTO releases VALUES(2, "Album 2: The Return", "CD002", "2012-04-05 00:00:00", "Artiste", "no");
INSERT INTO releases VALUES(3, "Album 3: Resurrection", "CD003", "2014-04-05 00:00:00", "Artiste", "yes");
INSERT INTO songs VALUES(1, 1, 1, "Song number 1", "00:03:16");
INSERT INTO songs VALUES(2, 1, 2, "Song number 2", "00:03:46");
INSERT INTO songs VALUES(3, 2, 1, "A new song", "00:06:16");
INSERT INTO songs VALUES(4, 3, 1, "Triple trouble", "00:04:26");
INSERT INTO songs VALUES(5, 3, 2, "Quadrouble", "00:04:56");
INSERT INTO shows VALUES(1, "2015-03-03 00:00:00", "Europe", "Finland", "Tornio", "Pikisaari", "Joku|www.testi.fi, Toinen|www.bandi.fi", "Nice show", "Eka|Toka|Kolmas", "Juha|Gtr, Mikko|Vox, Ville|Drums");
INSERT INTO shows VALUES(2, "2015-03-05 00:00:00", "Europe", "Finland", "Espoo", "Bodom", "Joku|www.testi.fi, Toinen|www.bandi.fi", "Nice show again", "Eka biisi|Toka|Kolmas", "Juha|Gtr, Mikko|Vox, Ville|Drums");

INSERT INTO photo_categories VALUES(1, "Promotional", "promo");
INSERT INTO photo_categories VALUES(2, "Studio", "studio");
INSERT INTO photo_categories VALUES(3, "Live", "live");
INSERT INTO photo_categories VALUES(4, "Misc", "misc");

INSERT INTO photo_albums VALUES(1, 1, "Promo pics from 2016", "All the promo pics taken during 2016");
INSERT INTO photo_albums VALUES(2, 1, "Older promo pics", "Promo pics taken before 2016");
INSERT INTO photo_albums VALUES(3, 2, "Studio 2016", "From the recording sessions of 2016");
INSERT INTO photo_albums VALUES(4, 3, "Live shows from summer", "Pics throughout the summer tour");
INSERT INTO photo_albums VALUES(5, 4, "Random stuff 15-16", "All kinds of interesting pics from 2015 and 2016");

INSERT INTO photos VALUES(1, 4, "2015-06-04 00:00:00", "Juha", "image1.jpg", "thumbnails/image1.jpg", "Live stuff");
INSERT INTO photos VALUES(2, 4, "2015-06-07 00:00:00", "Juha", "image2.jpg", "thumbnails/image2.jpg", "More live");
INSERT INTO photos VALUES(3, 4, "2015-07-04 00:00:00", "Juha", "image3.jpg", "thumbnails/image3.jpg", "Seen performing");
INSERT INTO photos VALUES(4, 1, "2016-04-12 00:00:00", "Juha", "image4.jpg", "thumbnails/image4.jpg", "New promo pic!");
INSERT INTO photos VALUES(5, 2, "2013-04-01 00:00:00", "Juha", "image5.jpg", "thumbnails/image5.jpg", "Previous promo");
INSERT INTO photos VALUES(6, 3, "2016-03-22 00:00:00", "Juha", "image6.jpg", "thumbnails/image6.jpg", "Latest work in the studio!");
INSERT INTO photos VALUES(7, 3, "2016-09-30 00:00:00", "Juha", "image7.jpg", "thumbnails/image7.jpg", "Recording new stuff!");
INSERT INTO photos VALUES(8, 5, "2014-01-12 00:00:00", "Juha", "image8.jpg", "thumbnails/image8.jpg", "Strange pic");
INSERT INTO photos VALUES(9, 5, "2012-10-03 00:00:00", "Juha", "image9.jpg", "thumbnails/image9.jpg", "Random session with electronics");

INSERT INTO photo_comments VALUES(1, 1, 1, "Nice picture", 3, "2016-03-18 00:00:00");
INSERT INTO photo_comments VALUES(2, 1, 2, "Yeah!", 3, "2016-03-18 01:00:00");
INSERT INTO photo_comments VALUES(3, 2, 1, "Cool stuff", 3, "2016-03-18 02:00:00");

INSERT INTO users VALUES(1, "Juha", "test2", "test2", 1);
INSERT INTO users VALUES(2, "Guest", "guest", "guest", 3);
INSERT INTO users VALUES(3, "Regular Joe", "name", "pass", 2);
INSERT INTO users VALUES(4, "Blocked", "nope", "nope", 4);

INSERT INTO user_access_levels VALUES(1, "Administrator");
INSERT INTO user_access_levels VALUES(2, "Normal User");
INSERT INTO user_access_levels VALUES(3, "Guest");
INSERT INTO user_access_levels VALUES(4, "Blocked");
