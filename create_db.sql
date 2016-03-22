CREATE USER 'teejii'@'localhost' IDENTIFIED BY 'samppeli';
GRANT ALL ON tech0.* TO 'teejii'@'localhost';

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
CREATE TABLE performers(id int, name varchar(200), type varchar(100), instrument varchar(100), started datetime, quit datetime, short_bio text, photo_id int, PRIMARY KEY(id));
CREATE TABLE videos(id int, title varchar(200), url text, host varchar(200), duration time, thumbnail varchar(200), category_id int, PRIMARY KEY(id));
CREATE TABLE video_categories(id int, name varchar(200), description varchar(500), PRIMARY KEY(id));

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

INSERT INTO performers VALUES(1, "Juha", "Founding member", "Guitar, Bass, Programming", "2000-01-01 00:00:00", "9999-12-12 23:59:59", "Started playing guitar in 1997 and wrote songs from 2000 on", 10);
INSERT INTO performers VALUES(2, "Tero", "Founding member", "Bass, Programming, Drums", "2000-01-01 00:00:00", "2004-10-12 23:59:59", "Drummer, bass player and co-songwriter from the beginning", 11);
INSERT INTO performers VALUES(3, "Matti", "Full member", "Vocals", "2007-11-01 00:00:00", "2011-12-12 23:59:59", "Joined on vocals after Wasteland and was in all live shows", 12);
INSERT INTO performers VALUES(4, "Ville", "Full member", "Drums", "2010-12-01 00:00:00", "9999-12-12 23:59:59", "Drumming since 2010 and first live drums on any of our albums with Devoid of Life", 13);
INSERT INTO performers VALUES(5, "Mikko", "Full member", "Vocals", "2012-03-01 00:00:00", "9999-12-12 23:59:59", "Joined on vocals after the nice performance on Devoid of Life", 14);
INSERT INTO performers VALUES(6, "Samuli", "Live member", "Bass", "2001-10-01 00:00:00", "2001-11-22 23:59:59", "Helped us out in our very first live performance", 15);
INSERT INTO performers VALUES(7, "Rami", "Rehearsal member", "Drums", "2001-10-01 00:00:00", "2002-04-12 23:59:59", "Played rehearsal drums for us for a good bit of time", 16);
INSERT INTO performers VALUES(8, "Lukas", "Guest artist", "Vocals", "2007-03-01 00:00:00", "2007-04-12 23:59:59", "Did some awesome guest vocals on The Core, from the album Wasteland", 17);

INSERT INTO photo_categories VALUES(5, "Band members", "band_members");
INSERT INTO photo_albums VALUES(6, 5, "Band member pictures", "All the members of the band");
INSERT INTO photos VALUES(10, 6, "2014-10-03 00:00:00", "Juha", "juha.jpg", "thumbnails/juha.jpg", "Juha 2014");
INSERT INTO photos VALUES(11, 6, "2014-10-03 00:00:00", "Tero", "tero.jpg", "thumbnails/tero.jpg", "Tero 2008");
INSERT INTO photos VALUES(12, 6, "2014-10-03 00:00:00", "Matti", "matti.jpg", "thumbnails/matti.jpg", "Matti 2010");
INSERT INTO photos VALUES(13, 6, "2014-10-03 00:00:00", "Ville", "ville.jpg", "thumbnails/ville.jpg", "Ville 2012");
INSERT INTO photos VALUES(14, 6, "2014-10-03 00:00:00", "Mikko", "mikko.jpg", "thumbnails/mikko.jpg", "Mikko 2014");
INSERT INTO photos VALUES(15, 6, "2014-10-03 00:00:00", "Samuli", "samuli.jpg", "thumbnails/samuli.jpg", "Samuli 2001");
INSERT INTO photos VALUES(16, 6, "2014-10-03 00:00:00", "Rami", "rami.jpg", "thumbnails/rami.jpg", "Rami 2008");
INSERT INTO photos VALUES(17, 6, "2014-10-03 00:00:00", "Lukas", "lukas.jpg", "thumbnails/lukas.jpg", "Lukas 2007");

INSERT INTO video_categories VALUES(1, "Live", "Videos from our live performances");
INSERT INTO video_categories VALUES(2, "Studio", "Studio videos from various recording sessions");
INSERT INTO video_categories VALUES(3, "Music videos", "Official music videos");
INSERT INTO video_categories VALUES(4, "Album videos", "Full album videos");
INSERT INTO videos VALUES(1, "The Live in Oulu", "http://www.vimeo.com/vortech", "Vimeo", "00:25:00", "videos/thumbnails/oulu2009.jpg", 1);
INSERT INTO videos VALUES(2, "Recording the album Of What Remains", "http://www.youtube.com/vortech", "Youtube", "00:10:00", "videos/thumbnails/owr-studio.jpg", 2);
INSERT INTO videos VALUES(3, "Disconnect (music video)", "http://www.vimeo.com/vortech", "Vimeo", "00:04:00", "videos/thumbnails/disconnect.jpg", 3);
INSERT INTO videos VALUES(4, "Devoid of Life (2016) - full album video", "http://www.vimeo.com/vortech", "Vimeo", "00:38:00", "videos/thumbnails/devoid-full.jpg", 4);
INSERT INTO videos VALUES(5, "The Occlusion (2014) - full album video", "http://www.vimeo.com/vortech", "Vimeo", "00:45:00", "videos/thumbnails/occlusion-full.jpg", 4);
INSERT INTO videos VALUES(6, "Random studio stuff", "http://www.vimeo.com/vortech", "Vimeo", "00:12:00", "videos/thumbnails/rand-studio.jpg", 2);
