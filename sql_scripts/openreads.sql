-- admin 0 ==> not admin ; 1 ==> admin
-- status 0 ==> author ; 1 ==> user
-- is_banned 0 ==> banned ; 1 ==> active
CREATE TABLE USER (
    id_user INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    lastname VARCHAR(30),
    username VARCHAR(20),
    email VARCHAR(50),
    profile_pic VARCHAR(50) DEFAULT 'default.jpg',
    bio VARCHAR(255) DEFAULT 'Default biography.',
    password VARCHAR(255),
    birthdate DATE,
    creation_date TIMESTAMP,
    status INTEGER,
    is_banned INTEGER,
    deathdate DATE,
    admin INTEGER DEFAULT 0,
    is_verified BOOLEAN
);
CREATE TABLE MESSAGE (
    id_message INTEGER PRIMARY KEY AUTO_INCREMENT,
    content VARCHAR(255),
    destinataire INTEGER REFERENCES USER(id_user) ON DELETE
    SET NULL,
        sent_date TIMESTAMP,
        seen_state BOOLEAN,
        id_user INTEGER REFERENCES USER(id_user) ON DELETE
    SET NULL
);
CREATE TABLE CHALLENGELIST (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    date_start TIMESTAMP,
    date_end TIMESTAMP,
    goal_books INTEGER
);
CREATE TABLE CHALLENGE (
    id_challenge INTEGER PRIMARY KEY AUTO_INCREMENT,
    date_start DATE,
    date_end DATE,
    name VARCHAR(50),
    goal_books INTEGER,
    nb_read INTEGER,
    id_user INTEGER NOT NULL REFERENCES USER(id_user) ON DELETE CASCADE,
    enCours INTEGER UNIQUE NOT NULL REFERENCES CHALLENGELIST(id)
);
CREATE TABLE BookToSell (
    id_bookToSell INTEGER PRIMARY KEY AUTO_INCREMENT,
    book_name VARCHAR(50),
    price DOUBLE,
    state INTEGER DEFAULT 1,
    description VARCHAR(255),
    publisher VARCHAR(50),
    nb_de_pages INTEGER,
    ISBN BIGINT,
    date_book DATE,
    date_published DATE,
    quantityItem INTEGER DEFAULT 1,
    main_img_name VARCHAR(70) DEFAULT 'default_bookImg.png',
    seller_user INTEGER NOT NULL REFERENCES USER(id_user) ON DELETE CASCADE,
    buyer_user INTEGER REFERENCES USER(id_user)
);
CREATE TABLE BookImage (
    id_image INTEGER PRIMARY KEY AUTO_INCREMENT,
    img_title INTEGER,
    img_name_path VARCHAR(70),
    id_book_to_sell INTEGER NOT NULL REFERENCES BookToSell(id_BookToSell) ON DELETE CASCADE
);
-- state 0 : normal, state 1 : delivered, state 2 : cancelled
CREATE TABLE ORDERS (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    dateOrder TIMESTAMP,
    quantity INTEGER,
    id_user INTEGER REFERENCES USER(id_user),
    id_seller INTEGER REFERENCES USER(id_user),
    state INTEGER DEFAULT 0,
    id_bookToSell INTEGER REFERENCES BookToSell(id_bookToSell)
);
CREATE TABLE Follows (
    followed_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    following_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(followed_user, following_user)
);
CREATE TABLE BLOCKS (
    blocked_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    blocking_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(blocked_user, blocking_user)
);
CREATE TABLE EVENT (
    id_event INTEGER PRIMARY KEY AUTO_INCREMENT,
    nb_places INTEGER,
    date TIMESTAMP,
    place VARCHAR(50)
);
CREATE TABLE PARTICIPE (
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    id_event INTEGER REFERENCES EVENT(id_event) ON DELETE CASCADE,
    PRIMARY KEY(id_event, id_user)
);
-- public 0 : Private ; 1 ==> Public
CREATE TABLE LIB (
    id_lib INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    public INTEGER DEFAULT 0,
    library_img VARCHAR(50) DEFAULT 'default_library.jpg',
    id_user INTEGER NOT NULL REFERENCES USER(id_user) ON DELETE CASCADE
);
CREATE TABLE GENRE (
    id_genre INTEGER PRIMARY KEY,
    name VARCHAR(30),
    description VARCHAR(255)
);
CREATE TABLE AIME_GENRE (
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    id_genre INTEGER REFERENCES GENRE(id_genre) ON DELETE CASCADE,
    PRIMARY KEY(id_user, id_genre)
);
CREATE TABLE AUTHOR (
    id_author INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    lastname VARCHAR(50)
);
-- Finished 0 ==> not finished ; 1 ==> finished
CREATE TABLE BOOK (
    id_book INTEGER PRIMARY KEY AUTO_INCREMENT,
    title_VF VARCHAR(50),
    synopsis TEXT(1000),
    release_date DATE,
    cover_img VARCHAR(50) DEFAULT 'default_bookImg.png',
    lang VARCHAR(20),
    finished INTEGER DEFAULT 0,
    genre INTEGER REFERENCES GENRE(id_genre),
    author INTEGER REFERENCES AUTHOR(id_author)
);
CREATE TABLE BOOKCOMPLETE (
    id_book INTEGER REFERENCES BOOK(id_book),
    id_user INTEGER REFERENCES USER(id_user),
    PRIMARY KEY(id_book, id_user)
);

CREATE TABLE AIME_BOOK (
    id_book INTEGER REFERENCES BOOK(id_book) ON DELETE CASCADE,
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(id_book, id_user)
);
CREATE TABLE EST_DANS_LIB(
    id_book INTEGER REFERENCES BOOK(id_book) ON DELETE CASCADE,
    id_lib INTEGER REFERENCES LIB(id_lib) ON DELETE CASCADE,
    PRIMARY KEY(id_book, id_lib),
    date_ajout DATE,
    date_debutLecture DATE,
    date_finLecture DATE
);
-- Deleted 0 : normal not deleted ; 1 ==> deleted 
CREATE TABLE REVIEW_BOOK (
    id_review INTEGER PRIMARY KEY AUTO_INCREMENT,
    comment TEXT(10000),
    rating INTEGER,
    time_stamp TIMESTAMP,
    deleted INTEGER DEFAULT 0,
    id_book INTEGER NOT NULL REFERENCES BOOK(id_book) ON DELETE CASCADE,
    id_user INTEGER REFERENCES USER(id_user) ON DELETE
    SET NULL,
        respond_to INTEGER REFERENCES REVIEW_BOOK(id_review)
);
CREATE TABLE LIKE_REVIEW (
    id_review INTEGER REFERENCES REVIEW_BOOK(id_review) ON DELETE CASCADE,
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(id_review, id_user),
    id_like INTEGER UNIQUE NOT NULL AUTO_INCREMENT
);
CREATE TABLE DISCUSSION_CATEGORIE (
    code_categorie CHAR(5) PRIMARY KEY,
    name VARCHAR(30),
    parent_categorie VARCHAR(10)
);
CREATE TABLE DISCUSSION (
    id_discussion INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    categorie CHAR(5),
    op INTEGER,
    FOREIGN KEY (categorie) REFERENCES DISCUSSION_CATEGORIE(code_categorie) ON DELETE CASCADE,
    FOREIGN KEY (op) REFERENCES USER(id_user) ON DELETE
    SET NULL
);
-- Deleted 0 ==> not deleted normal ; 1 ==> deleted 
CREATE TABLE POST (
    id_post INTEGER PRIMARY KEY AUTO_INCREMENT,
    content VARCHAR(10000),
    id_user INTEGER,
    id_discu INTEGER,
    post_date TIMESTAMP,
    deleted INTEGER DEFAULT 0,
    FOREIGN KEY (id_user) REFERENCES USER(id_user) ON DELETE
    SET NULL,
        FOREIGN KEY (id_discu) REFERENCES DISCUSSION(id_discussion) ON DELETE CASCADE
);
CREATE TABLE LIKE_POST (
    id_post INTEGER REFERENCES POST(id_post) ON DELETE CASCADE,
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(id_post, id_user),
    id_like INTEGER UNIQUE NOT NULL AUTO_INCREMENT
);
CREATE TABLE LIKE_DISCUSSION (
    id_discussion INTEGER REFERENCES DISCUSSION(id_discussion) ON DELETE CASCADE,
    id_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    PRIMARY KEY(id_user, id_discussion),
    id_like INTEGER UNIQUE NOT NULL
);
CREATE TABLE CAPTCHA (
    id_captcha INTEGER PRIMARY KEY AUTO_INCREMENT,
    questions VARCHAR(255),
    goodAnswer VARCHAR(255)
);
CREATE TABLE TOKEN (
    id_token INTEGER PRIMARY KEY AUTO_INCREMENT,
    token_value CHAR(50),
    token_type CHAR(7),
    expiration_date DATE,
    user INTEGER NOT NULL REFERENCES USER(id_user) ON DELETE CASCADE
);

CREATE TABLE NEWSLETTER (
    id_nl INTEGER PRIMARY KEY AUTO_INCREMENT,
    subject VARCHAR(150),
    paragraph01 TEXT(1000),
    paragraph02 TEXT(1000),
    paragraph03 TEXT(1000),
    is_selected BOOLEAN
);
CREATE TABLE REPORT_USER (
    id_report_user INTEGER PRIMARY KEY AUTO_INCREMENT,
    reporting_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    reported_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    date_report TIMESTAMP,
    processing_status INTEGER,
    reason_report INTEGER
);
CREATE TABLE REPORT_REVIEW (
    id_report_review INTEGER PRIMARY KEY AUTO_INCREMENT,
    reporting_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    reported_review INTEGER REFERENCES REVIEW_BOOK(id_review) ON DELETE CASCADE,
    date_report TIMESTAMP,
    processing_status INTEGER,
    reason_report INTEGER
);
CREATE TABLE REPORT_POST (
    id_report_post INTEGER PRIMARY KEY AUTO_INCREMENT,
    reporting_user INTEGER REFERENCES USER(id_user) ON DELETE CASCADE,
    reported_post INTEGER REFERENCES POST(id_post) ON DELETE CASCADE,
    date_report TIMESTAMP,
    processing_status INTEGER,
    reason_report INTEGER
);
CREATE TABLE BAN_WORD (
    id__word INTEGER PRIMARY KEY AUTO_INCREMENT,
    word VARCHAR(100) NOT NULL
);


CREATE TABLE BACKUP (
    id_bkp INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    date TIMESTAMP,
    size INT UNSIGNED
);
