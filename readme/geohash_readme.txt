Geohashes are a way to succinctly express a location.  Where you might use 16 characters to describe the location of a building footprint using a lat/lng pair, you can get the same accuracy using an 8-character geohash.  This is important if you want to load 6000 points in one go.  They can also help with fast algorithms for location comparisons/etc.  You can find a good illustration of these codes here: http://geohash.gofreerange.com/

If you are describing a lot of buildings really close to each other, you can use a compression algorithm to take advantage of this proximity.  The following is the algorithm I used to encode our dataset:

1. Sort the geohashes in alphabetical order
2. Print the first 5 characters of the first geohash
3. For each geohash that starts with these 5 letters, print the next three letters in it.
4. Our buildings are going to be one of 6 different types, so let's add a number representing the type after each partial hash (this will allow us to display the correct icon).
5. When a geohash is reached that contains a different 5 characters, print a flag character (i.e., '~') followed by the number of characters in the prefix that differ (n), followed by the last n characters in the next 5 character prefix.
6. Return to step 3 and repeat until last hash is coded in this manner.