USE cs105_bc23784;

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
	username	VARCHAR(30) NOT NULL PRIMARY KEY,
	password	VARCHAR(50)
);

DROP TABLE IF EXISTS albums CASCADE;
CREATE TABLE albums (
	username	VARCHAR(30) REFERENCES users,
	albumTitle	VARCHAR(30),
	albumPath	VARCHAR(128)
);

DROP TABLE IF EXISTS pictures CASCADE;
CREATE TABLE pictures (
	username	VARCHAR(30) REFERENCES users,
	albumTitle	VARCHAR(30) REFERENCES albums,
	albumPath	VARCHAR(128) REFERENCES albums,
	picTitle	VARCHAR(35)
);

DROP TABLE IF EXISTS profiles CASCADE;
CREATE TABLE profiles (
	username 	VARCHAR(30) NOT NULL PRIMARY KEY REFERENCES users,
	fact1		VARCHAR(750),
	fact2		VARCHAR(750),
	fact3		VARCHAR(750),
	profPicPath	VARCHAR(128)		
);

DROP TABLE IF EXISTS messages CASCADE;
CREATE TABLE messages (
	op			VARCHAR(30) NOT NULL REFERENCES users,
	toUser		VARCHAR(30) NOT NULL REFERENCES users,
	message		VARCHAR(1200),
	datetime	VARCHAR(30)
);

-- four users, one album per user, three pictures per album

INSERT INTO users (username, password)
	VALUES ('bc23784', 'cf2962351ee7c8d1ea2d1f54bfba88531c2a40cf');		-- sha1 hash fxn, 'meatpuppet123!'
INSERT INTO users (username, password)									
	VALUES ('bendy78', 'dc0b16d9e34515ee180b5ad587370c259aa773dd');		-- sha1 hash fxn, 'Abc123!'
INSERT INTO users (username, password)
	VALUES ('peatmuppet', 'dc0b16d9e34515ee180b5ad587370c259aa773dd');
INSERT INTO users (username, password)
	VALUES ('meatpuppet', 'dc0b16d9e34515ee180b5ad587370c259aa773dd');

INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('bc23784', 'Bendy', 'bc23784/Bendy');
INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass');
INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery');
INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('bendy78', 'Llamas', 'bendy78/Llamas');
INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('meatpuppet', 'Donkeys', 'meatpuppet/Donkeys');
INSERT INTO albums (username, albumTitle, albumPath)
	VALUES ('peatmuppet', 'Giraffasaurus', 'peatmuppet/Giraffasaurus');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'Bendy', 'bc23784/Bendy', '1.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'Bendy', 'bc23784/Bendy', '2.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'Bendy', 'bc23784/Bendy', '3.jpg');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Buddha.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'HKI.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Moi.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Peak.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Peninsula.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Pig.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Pizza.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'StPaul.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Street.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'ILoveThisClass', 'bc23784/ILoveThisClass', 'Tower.jpg');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '1.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '2.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '3.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '4.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '5.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '6.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '7.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '8.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '9.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bc23784', 'SeanConnery', 'bc23784/SeanConnery', '10.jpg');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bendy78', 'Llamas', 'bendy78/Llamas', '1.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bendy78', 'Llamas', 'bendy78/Llamas', '2.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('bendy78', 'Llamas', 'bendy78/Llamas', '3.jpg');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('meatpuppet', 'Donkeys', 'meatpuppet/Donkeys', '1.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('meatpuppet', 'Donkeys', 'meatpuppet/Donkeys', '2.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('meatpuppet', 'Donkeys', 'meatpuppet/Donkeys', '3.jpg');

INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('peatmuppet', 'Giraffasaurus', 'peatmuppet/Giraffasaurus', '1.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('peatmuppet', 'Giraffasaurus', 'peatmuppet/Giraffasaurus', '2.jpg');
INSERT INTO pictures (username, albumTitle, albumPath, picTitle)
	VALUES ('peatmuppet', 'Giraffasaurus', 'peatmuppet/Giraffasaurus', '3.jpg');

INSERT INTO profiles (username, fact1, fact2, fact3, profPicPath)
	VALUES ('bc23784', 'Hello', 'World', 'Goodbye', '');
INSERT INTO profiles (username, fact1, fact2, fact3, profPicPath)
	VALUES ('bendy78', 'Hello', 'World', 'Goodbye', '');
INSERT INTO profiles (username, fact1, fact2, fact3, profPicPath)
	VALUES ('meatpuppet', 'Hello', 'World', 'Goodbye', '');
INSERT INTO profiles (username, fact1, fact2, fact3, profPicPath)
	VALUES ('peatmuppet', 'Hello', 'World', 'Goodbye', '');

-- INSERT INTO messages (op, toUser, message, dateTime)
-- 	VALUES ('bendy78', 'bc23784', 'u r g(8 - t)', '2013-09-15 15:25:49');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('meatpuppet', 'bc23784', 'moop', '2013-10-02 22:14:59');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('peatmuppet', 'bc23784', 'poom', '2013-10-09 14:28:24');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('bendy78', 'bc23784', 'u suk' , '2013-10-14 09:34:15');

-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('bc23784', 'bendy78', 'u suk' , '2013-10-14 09:34:15');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('peatmuppet', 'bendy78', 'u suk' , '2013-10-15 10:34:15');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('peatmuppet', 'bendy78', 'u suk' , '2013-10-16 11:34:15');
-- INSERT INTO messages (op, toUser, message, dateTime)
-- VALUES ('meatpuppet', 'bendy78', 'u suk' , '2013-10-17 12:34:15');
