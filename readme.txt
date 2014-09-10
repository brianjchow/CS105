BUG FIXES/CHANGELOG (cumulative from previous versions)
---------------------------------------------------------------------

v5

- class_lib_test.php
    - functionizing image uploading causes all scripts to fail

- view.php
    - untested: script behaviour if there are no images in the folder
    - how to centre image - probably implement table and/or set div element (no time)

- updateHandler.php and postMessageHandler.php
    - implement number of characters check; reject if over 250 or 500 characters, respectively
	- FIXED IN v5

- testupload2.php
    - check name of picture being submitted against database of names; reject if name already exists
	- FIXED IN v5
    - figure out what to do during password checks if user-entered password is invalid

- global (form handlers)
    - make sure function redir() does what it's supposed to do with regard to filling in already-entered information

- functionality additions
    - added primitive search feature (SQL)
    - added function redir() in signup2.php, testupload2.php to handle illegal inputs
    - increased picTitle field in initialize.sql from 30 to 35 (to handle filename extensions) (SQL)
    - added # chars remaining readouts to forms involving facts and message board posts (SQL)
    - reduced message board message length to 400 chars; increased length of message field in messages SQL table to 1200, to account for message encoding
	(although encoding isn't really necessary right now)
    - moved message board message checking tests to JS in postMessage.php (from postMessageHandler.php)

------------------------------

v4

- no major bugfixes

- functionality additions
    - added sign in/out ability (SQL)
    - now required to sign in in order to do pretty much anything (SQL)
    - changed behaviour of toolbar to reflect whether or not a user is signed in
    - moved picture generation in albums to client-side (JS script)
    - added primitive message board (SQL)
    - "library-ized" repeated functions within all pages

------------------------------

v3

album.php/delete.php/deleteHandler.php/view.php
	- current implementation passes picture path through URL

signup1.html, testupload1.html, newalbum1.html
	- reinstate ability to have names and titles with non-alphanumeric characters (use read_escape_string() and urlencode()/urldecode())

testupload2.php
	- albumExists check - consider case when mkdir fails (if/else) ?
	- uploading another file with the same name as one currently present in the album will overwrite the older file
	    - FIXED IN v5
	- moving the check for if the album exists to the top will eliminate the need to have the if/else with two copies of the upload code
	    - FIXED IN v5

global
	- table formatting not being recognised (CSS link is broken)
	- remove echo statements redirecting users to one of the main pages
	- check that all user input is filtered
	- use read_escape_string() on all inputted strings (e.g., $temp = $db_server->read_escape_string($string);)
	- ensure that $![database query] checks are in place everywhere
	    - FIXED IN v5
	- allow use of spaces and non-alphanumeric characters in username? (use read_escape_string() and urlencode()/urldecode())
	


