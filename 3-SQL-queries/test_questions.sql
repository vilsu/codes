-- users
INSERT INTO users (username, email, passhash_md5)
    VALUES ('masi', 'masi@gmail.com', 'otehuuuuuu2');

INSERT INTO users (username, email, passhash_md5)
    VALUES ('cha', 'cha@gmail.com', 'oouhoutehuuuuuu2');

INSERT INTO users (username, email, passhash_md5)
    VALUES ('aapo', 'aapo@gmail.com', 'aapootehuuuuuu2');

-- questions
INSERT INTO questions (user_id, title, body) 
    VALUES (1, 'Title_1', 'Body_2');

INSERT INTO questions (user_id, title, body)
    VALUES (2, 'Test_2_title', 'Test_2_body');

-- tags
INSERT INTO tags (tag, question_id)
    VALUES ('php', 1);

INSERT INTO tags (tag, question_id)
    VALUES ('scripts', 1);

INSERT INTO tags (tag, question_id)
    VALUES ('ssh', 2);

INSERT INTO tags (tag, question_id)
    VALUES ('network', 2);
