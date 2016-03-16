CREATE DATABASE tech0;
USE tech0;
CREATE TABLE news(id int, title varchar(255), contents text, posted datetime, author varchar(255), tags varchar(1000), PRIMARY KEY(id));
CREATE TABLE releases(id int, title varchar(255), release_code varchar(10), release_date datetime, artist varchar(100), has_cd varchar(3), PRIMARY KEY(id));
CREATE TABLE songs(song_id int, release_id int, release_song_id int, title varchar(255), duration time, PRIMARY KEY(song_id));
CREATE TABLE news_comments(id int, comment_subid int, news_id int, author varchar(200), comment text, posted datetime, PRIMARY KEY(id));
CREATE TABLE release_comments(id int, comment_subid int, release_id int, author varchar(200), comment text, posted datetime, PRIMARY KEY(id));
