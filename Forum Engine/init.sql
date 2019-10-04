DROP TABLE IF EXISTS post;

 CREATE TABLE post (
     id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
     title VARCHAR(200) NOT NULL,
     body  VARCHAR(200) NOT NULL,
     user_id INTEGER NOT NULL,
     created_at VARCHAR(200) NOT NULL,
     updated_at VARCHAR(200)
 );

 INSERT INTO
    post
    (
        title, body, user_id, created_at
    )
    VALUES(
        "Here's our first post",
        "This is the body of the first post.
        
        It is split into paragraphs.",
        1,
        NOW()
    )
;

 INSERT INTO
    post
    (
        title, body, user_id, created_at
    )
    VALUES(
        "Here's our second post",
        "This is the body of the second post.
        
        It is split into paragraphs.",
        1,
        DATE_ADD(NOW(), INTERVAL 2 HOUR)
    )
;

 INSERT INTO
    post
    (
        title, body, user_id, created_at
    )
    VALUES(
        "Here's our third post",
        "This is the body of the third post.
        
        It is split into paragraphs.",
        1,
        DATE_ADD(NOW(), INTERVAL 6 HOUR)
    )
;

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    post_id INTEGER NOT NULL,
    created_at VARCHAR(50) NOT NULL,
    person VARCHAR(50) NOT NULL,
    website VARCHAR(50) NOT NULL,
    the_text VARCHAR(200) NOT NULL
);

INSERT INTO
    comment
    (
        post_id, created_at, person, website, the_text
    )
    VALUES(
        1,
        DATE_ADD(now(), INTERVAL 1 HOUR),
        'Jimmy',
        'http://example.com/',
        'This is Jimmys contribution'
    );

INSERT INTO
    comment
    (
        post_id, created_at, person, website, the_text
    )
    VALUES(
        1,
        DATE_ADD(now(), INTERVAL 2 HOUR),
        'Johnny',
        'http://example2.com/',
        'This is Johnnys contribution'
    );

CREATE TABLE user (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(20) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    created_at VARCHAR(50) NOT NULL,
    is_enabled BOOLEAN NOT NULL DEFAULT true
);


