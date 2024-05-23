/* 
    This script creates a bunch of user with a book and review book to test profile.php
*/

INSERT INTO USER(name, lastname, username, email, password, birthdate, creation_date, status, is_verified) 
VALUES ('name1', 'lastname1', 'usr1', 'user1@gmail.com', 'password01', '2000-01-01', '2024-01-01', 0, 1);

INSERT INTO USER(name, lastname, username, email, password, birthdate, creation_date, status, is_verified) 
VALUES ('name2', 'lastname2', 'usr2', 'user2@gmail.com', 'password02', '2000-01-01', '2024-01-01', 0, 1);

-- Test that the book's reviews appears correctly
INSERT INTO BOOK(title_VF, synopsis, release_date, cover_img, lang)
VALUES ('Book1', 'This is an example synopsis1.', '2023-01-15', 'example_cover.png', 'English');
INSERT INTO BOOK(title_VF, synopsis, release_date, cover_img, lang)
VALUES ('Book2', 'This is an example synopsis2.', '2023-01-15', 'example_cover.png', 'English');

INSERT INTO REVIEW_BOOK(comment, rating, time_stamp, id_book, id_user) VALUES('This is a nice book', 10, CURRENT_TIMESTAMP, 1, 1);
INSERT INTO REVIEW_BOOK(comment, rating, time_stamp, id_book, id_user) VALUES('This book is bad', 10, CURRENT_TIMESTAMP, 2, 1);

-- Test that the number of following users and followed users are right
INSERT INTO Follows(followed_user, following_user) VALUES(1, 2);
INSERT INTO Follows(followed_user, following_user) VALUES(2, 1);

-- Insert libraries for user id=1 to test if libraries are working well
INSERT INTO LIB(name, id_user) VALUES('biblio1', 1);
INSERT INTO LIB(name, id_user) VALUES('biblio1', 2);