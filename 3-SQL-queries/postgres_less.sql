DROP TABLE questions;
DROP TABLE tags;
DROP TABLE users;
DROP TABLE answers;

-- INTEGER 0 and 1 for false and true, respectively
-- this needs to be first because other tables refer to it
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY NOT NULL,      
    username VARCHAR(320) NOT NULL,
    email VARCHAR(320) NOT NULL UNIQUE,
    passhash_md5 VARCHAR(33) NOT NULL,
    a_moderator INTEGER NOT NULL DEFAULT 0,
    logged_in INTEGER NOT NULL DEFAULT 0,
    has_been_sent_a_moderator_message INTEGER NOT NULL DEFAULT 1,
    CONSTRAINT email_to_user_id UNIQUE (email, user_id)
);

CREATE TABLE questions (
    question_id SERIAL PRIMARY KEY NOT NULL UNIQUE, 
    user_id INTEGER NOT NULL 
        REFERENCES users(user_id), 
    body TEXT NOT NULL DEFAULT '',
    title VARCHAR(320) NOT NULL,
    flagged_for_moderator_removal INTEGER NOT NULL DEFAULT 0,
    was_last_checked_by_moderator_at_time TIMESTAMP, 
    was_sent_at_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT no_duplicate_questions UNIQUE (title, body)
);

CREATE TABLE tags (
    tag_id SERIAL NOT NULL PRIMARY KEY,
    tag VARCHAR(320) NOT NULL,
    question_id INTEGER NOT NULL, 
    CONSTRAINT no_duplicate_tag UNIQUE (question_id, tag)
);

CREATE TABLE answers (
    answer_id SERIAL PRIMARY KEY NOT NULL,
    answer TEXT NOT NULL DEFAULT '',
    question_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    was_sent_at_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    flagged_for_moderator_removal INTEGER NOT NULL DEFAULT 0,
    CONSTRAINT no_duplicate_answers UNIQUE (question_id, answer)
);
