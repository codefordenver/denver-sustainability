[![Stories in Ready](https://badge.waffle.io/codefordenver/denver-sustainability.png?label=ready&title=Ready)](https://waffle.io/codefordenver/denver-sustainability)
###Building a Sustainable Denver

######A php/MySQL project that displays buildings on a map and color codes them based on their level of commitment to sustainability.

<p>At present, everything is written in HTML and Javascript (with JQuery) with a little bit of Mustache templating thrown in.  MaterializeCSS is used to provide a sliding drawer and bubbling buttons.  AJAX calls are made to get the map markers and details for the buildings.</p>

#####Running/Editing Locally
The most basic setup requires only a web browser and text editor.  By default, the database and services are on a remote server.  If you want to install things locally, you will need to get PHP and MySQL running.

#####Geohashes
Geohashes are a way to succinctly express a location.  Where you might use 16 characters to describe the location of a building footprint using a lat/lng pair, you can get the same accuracy using an 8-character geohash.  This is important if you want to load 6000 points in one go.  They can also help with fast algorithms for location comparisons/etc.  You can find a good illustration of these codes here: http://geohash.gofreerange.com/

<P>If you are describing a lot of buildings really close to each other, you can use a compression algorithm to take advantage of this proximity.  The following is the algorithm I used to encode our dataset:</P>

<ol><li>Sort the geohashes in alphabetical order</li>
<li>Print the first 5 characters of the first geohash</li>
<li>For each geohash that starts with these 5 letters, print the next three letters in it.</li>
<li>Our buildings are going to be one of 6 different types, so let's add a number representing the type after each partial hash (this will allow us to display the correct icon).</li>
<li>When a geohash is reached that contains a different 5 characters, print a flag character (i.e., '~') followed by the number of characters in the prefix that differ (n), followed by the last n characters in the next 5 character prefix.</li>
<li>Return to step 3 and repeat until last hash is coded in this manner.</li>
</ol>

#####Database
A simple MySQL database that contains a row for each building and corresponding rows for certifications and strategies associated with the building.  There is a dump file in the backup_database folder.  You can install the schema and data by using the Import function in your MySQL tool of choice.  There is a file in the php folder called <b>config.php</b> that contains constants for the database host, username, password, and database name.

#####File Structure
path | description
---- | -----------
index.html | Has the map view. Here users can see the map and get stats on buildings in Denver.  Some stuff is broken out into the html and js folders
info.html | Has the about us information.
simpHTTP.py | Use this script as a local server to host the website while you are working on new contributions. 
backup_database/ | Dump of the mysql database
html/ | Some of the page content (sometimes using Mustache templates).  For example, bottom_drawer_splash.html is the splash screen that appears in the bottom drawer when you first open the page.
images/ | The marker images, header images, certification badges, etc.
js/ | A lot of the mapping and decoding logic is in here.  Third party libs are in the lib folder.
php/ | Contains files that access database and grab building data.  If you want to do a local install, change the BASE_URL javascript variable in index.html to point to localhost.  Change config.php to match your db params.
styles/ | CSS for page.  /lib contains third-party libs.
