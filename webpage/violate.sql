
/*This violates the PRIMARY KEY contraint for the Movie table because
the id 2 already exists. Primary keys cannot be null or have duplicate entries.
ERROR OUTPUT: ERROR 1062 (23000) at line 6: Duplicate entry '2' for key 1
*/
INSERT INTO Movie VALUES(2,'test',2012,'test','test');


/*This violates the PRIMARY KEY contraints for the Actor table because
the id 10 already exists within the table.  Primary keys cannot have duplicate
entries or be NULL.
ERROR OUTPUT: ERROR 1062 (23000) at line 13: Duplicate entry '10' for key 1*/

INSERT INTO Actor VALUES(10, 'test', 'test', 'Male',19750503, NULL );

/*The following command violates the PRIMARY KEY constraiint for the Director table because the id 16 already exists within the table.  Primary keys cannot have duplicates or be NULL.
ERROR OUTPUT: ERROR 1062 (23000) at line 16: Duplicate entry '16' for key 1*/

INSERT INTO Director VALUES(16, 'test', 'test', 19750503, NULL );

/*The following command would fail the check constraint in Actor where sex
can only be Male or Female. Clearly NOTFEM is not one of those entries; thus
this update command would fail. */

UPDATE Actor
SET sex='NOTFEM'
WHERE id=10;


/*The following update command will violate the check constraint on the Movie table where all years must be non-negative because it updates the year of the tuple containing id(2) to -1.
*/

UPDATE Movie
SET year=-1
WHERE id=2;


/*The following command violates the check contraint on the Review table where
all ratings must be between 0 and 5.  Because this command sets all ratings that are greater than 3 to -1, an error would occur from the check constraint*/

UPDATE Review
SET rating=-1
WHERE rating>3;



/*
The following deletion command violates the referential integrity of the table.
The MovieGenre table references the Movie table's id.  When the row containing
id=2 in the Movie table is deleted, the mid=2 in MovieGenre would not reference anything and the referential-integrety would be violated.

Error Output:
ERROR 1451 (23000) at line 56: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

DELETE FROM Movie
WHERE id=2;

/*
The following update command violates the referential integrity of the two tables because id=100 of Movie is referenced by mid=100 of MovieActor.  When id=100 is updated, because the foreign key does not have update on cascade, the referential integrity is violated.
Although the error output below states MovieGenre, the MovieActor table is also violated.

ERROR 1451 (23000) at line 60: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
*/
UPDATE Movie
SET id=101
where id=100;



/*
The following deletion command would violate the referential integrity of the tables because id 180 in Actor is referenenced by aid 180 in MovieActor. Deletion of id 180 in Actor would violate the referential integrity.

ERROR 1451 (23000) at line 67: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
*/

DELETE FROM Actor
WHERE id=180;


/*
The following deletion violates the referential integrity of the tables because
id=974 in Director is referenced by did in MovieDirector.  The error occurs
when id=974 was deleted.

ERROR 1451 (23000) at line 77: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))
*/

DELETE FROM Director
where id=974;

/*
The following update command will violate the referential integrity of the tables because did=1019 MovieDirector references id=1019 in Movie, and the error occurs upon deletion of 1019.

ERROR 1451 (23000) at line 93: Cannot delete or update a parent row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))*/

UPDATE Movie
SET id=0
WHERE id=1019;


/* Suppose that the review table has a mid=9 that references the id=9 in Movie.
The following deletion would violate the referential integrity between the Review and Movie tables because review mid=9 references id=9 in Movie.  An error would occur upon deletion of the id=9 tuple in Movie.
*/

DELETE FROM Movie
WHERE id=9;
