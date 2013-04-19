
/*Constraints:
Movie id is the primary key because id's are assumed to have an actual value and
be unique.
A movie should have a non-NULL positive year when the movie was released*/
CREATE TABLE Movie(
    id int,
    title varchar(100) NOT NULL,
    year int NOT NULL,
    rating varchar(10),
    company varchar(50),
    PRIMARY KEY(id),
    CHECK (year >= 0)) ENGINE=INNODB;

/*
Actor id is a primary key because id's have actual value and are unique.
The check constraint for sex is to limit the choices to just Male or Female.*/

CREATE TABLE Actor(
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    sex varchar(6) NOT NULL,
    dob DATE NOT NULL,
    dod DATE,
    PRIMARY KEY(id),
    CHECK (sex IN ('Male', 'Female'))
    ) ENGINE=INNODB;

/*
Director id is also unique and a non-NULL value; therefore it has the function of a primary key.
*/
CREATE TABLE Director(
    id int,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    dob DATE NOT NULL,
    dod DATE,
    PRIMARY KEY(id)) ENGINE=INNODB;

/*
MovieGenre mid should be a foreign key that references the primary key Movie id because those id's are the exact same id's.
*/
CREATE TABLE MovieGenre(
    mid int NOT NULL,
    genre varchar(20), 
    FOREIGN KEY(mid) references Movie(id) ON DELETE CASCADE ON UPDATE CASCADE)
    ENGINE=INNODB;

/*mid references Movie id, and did references Director id.
Because these values would be shared, they should be referenced by a foreign key*/
CREATE TABLE MovieDirector(
    mid int NOT NULL,
    did int NOT NULL,
    FOREIGN KEY(mid) references Movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(did) references Director(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=INNODB;

/*mid and aid references Movie id and Actor id respectively; therefore they should be foreign keys. */
CREATE TABLE MovieActor(
    mid int NOT NULL,
    aid int NOT NULL,
    role varchar(50),
    FOREIGN KEY(mid) references Movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(aid) references Actor(id) ON DELETE CASCADE ON UPDATE CASCADE)
    ENGINE=INNODB;

/* mid references Movie id; therefoe it should be a foreign key.
I assume that ratings are between 0 and 5 by the check constraint */
CREATE TABLE Review(
    name varchar(20) NOT NULL,
    time TIMESTAMP,
    mid int NOT NULL,
    rating int,
    comment varchar(500),
    FOREIGN KEY(mid) references Movie(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CHECK (rating>=0 AND rating<=5)) ENGINE=INNODB;

CREATE TABLE MaxPersonID(id int);

CREATE TABLE MaxMovieID(id int);

INSERT INTO MaxPersonID VALUES(6900);
INSERT INTO MaxMovieID VALUES(4750);
