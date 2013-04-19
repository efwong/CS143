/*Query: get the names of all actors in the movie 'Die Another Day'
Get a cartesian product of Movie, MovieActor and Actor, then match
the movie title, movie id and actor id to get tuples that contain the movie
information and actor information.  At the end select the actor's last
and first name.*/
SELECT last, first 
FROM Movie, MovieActor, Actor
WHERE Movie.id=mid AND title='Die Another Day'AND Actor.id=aid;

/*Query: Get the count of all actors who acted in multiple movies
First compare the MovieActor table with itself and find entries with the
same actor but in a different movie ( different mid ).  Select unique actors
and these will be the actors that starred in more than one movie.  Then
get the count of these actors. */
SELECT count(temp.actorid)
FROM (SELECT DISTINCT first.aid as actorid
      FROM MovieActor as first, MovieActor as sec
      WHERE first.aid=sec.aid and first.mid<>sec.mid) as temp;

/*Query: Get the title of all Sci-Fi movies released in the year 2000
First compare the tables Movie and MovieGenre. Between the two tables
get the tuples with the same movie id, made in 2000, and Sci-Fi genre.
*/

SELECT DISTINCT title
FROM Movie, MovieGenre
WHERE year=2000 AND mid=id AND genre='Sci-Fi';
